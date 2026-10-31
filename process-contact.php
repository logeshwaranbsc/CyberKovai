<?php
/**
 * Cyber Kovai - Contact Form Processor with reCAPTCHA Verification & Google Sheets Lead Integration
 */

require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

$response = [
    'success' => false,
    'message' => 'Invalid request method.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic Honeypot / Spam Trap Check (if hidden honeypot is populated, reject silently)
    if (!empty($_POST['website']) || !empty($_POST['hp_time'])) {
        $response['message'] = 'Spam submission detected.';
        echo json_encode($response);
        exit;
    }

    // Sanitize and trim inputs
    $name    = isset($_POST['name']) ? trim(strip_tags((string)$_POST['name'])) : '';
    $email   = isset($_POST['email']) ? trim((string)$_POST['email']) : '';
    $phone   = isset($_POST['phone']) ? trim(strip_tags((string)$_POST['phone'])) : '';
    $service = isset($_POST['service']) && trim((string)$_POST['service']) !== '' 
               ? trim(strip_tags((string)$_POST['service']))
               : (isset($_POST['service_interest']) ? trim(strip_tags((string)$_POST['service_interest'])) : '');
    $message = isset($_POST['message']) ? trim(strip_tags((string)$_POST['message'])) : '';
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    // Validate required fields
    if ($name === '') {
        $response['message'] = 'Please enter your name or pseudonym.';
        echo json_encode($response);
        exit;
    }

    if (mb_strlen($name, 'UTF-8') > 120) {
        $response['message'] = 'Name is too long (maximum 120 characters).';
        echo json_encode($response);
        exit;
    }

    $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$validEmail || mb_strlen($email, 'UTF-8') > 150) {
        $response['message'] = 'Please provide a valid email address.';
        echo json_encode($response);
        exit;
    }

    if ($phone === '') {
        $response['message'] = 'Please provide your phone, WhatsApp, or Signal number.';
        echo json_encode($response);
        exit;
    }

    if (mb_strlen($phone, 'UTF-8') < 7 || mb_strlen($phone, 'UTF-8') > 35) {
        $response['message'] = 'Please provide a valid contact number (7 to 35 characters).';
        echo json_encode($response);
        exit;
    }

    if ($service === '') {
        $response['message'] = 'Please select the service required.';
        echo json_encode($response);
        exit;
    }

    if (mb_strlen($service, 'UTF-8') > 150) {
        $response['message'] = 'Selected service name is invalid.';
        echo json_encode($response);
        exit;
    }

    if ($message === '') {
        $response['message'] = 'Please provide your confidential details or message.';
        echo json_encode($response);
        exit;
    }

    if (mb_strlen($message, 'UTF-8') > 4000) {
        $response['message'] = 'Message is too long (maximum 4000 characters).';
        echo json_encode($response);
        exit;
    }

    // Verify reCAPTCHA token if reCAPTCHA is enabled and secret key is configured
    if (defined('ENABLE_RECAPTCHA') && ENABLE_RECAPTCHA) {
        $secretKey = defined('RECAPTCHA_SECRET_KEY') ? RECAPTCHA_SECRET_KEY : '';
        if (!empty($secretKey)) {
        if (empty($recaptchaResponse)) {
            $response['message'] = 'Please complete the reCAPTCHA verification.';
            echo json_encode($response);
            exit;
        }

        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $postData = [
            'secret'   => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
        ];

        $captchaValid = false;

        if (function_exists('curl_init')) {
            $ch = curl_init($verifyUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            $verifyBody = curl_exec($ch);
            curl_close($ch);
        } else {
            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($postData),
                    'timeout' => 10
                ]
            ];
            $context = stream_context_create($options);
            $verifyBody = @file_get_contents($verifyUrl, false, $context);
        }

        if ($verifyBody) {
            $verifyJson = json_decode($verifyBody, true);
            if (!empty($verifyJson['success'])) {
                $captchaValid = true;
            }
        }

        if (!$captchaValid) {
            $response['message'] = 'reCAPTCHA verification failed. Please try again.';
            echo json_encode($response);
            exit;
        }
        }
    }

    // ---------------------------------------------------------
    // Submit Lead to Google Sheets via Google Apps Script Web App
    // ---------------------------------------------------------
    $googleScriptUrl = defined('GOOGLE_SCRIPT_URL') 
        ? GOOGLE_SCRIPT_URL 
        : 'https://script.google.com/macros/s/AKfycbxCF61hcrOSjTVht96TrymhNCjzLCRPyeRByyD4t1OYRy96c6SMkjqyh-PLnsR_3zztfA/exec';

    $googleSheetsSecret = defined('GOOGLE_SHEETS_SECRET') ? GOOGLE_SHEETS_SECRET : '';

    $leadPayload = [
        'token'   => $googleSheetsSecret,
        'name'    => $name,
        'email'   => $email,
        'phone'   => $phone,
        'service' => $service,
        'message' => $message,
    ];

    $jsonPayload = json_encode($leadPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $sheetSuccess = false;
    $sheetErrorMessage = '';

    if (function_exists('curl_init')) {
        $ch = curl_init($googleScriptUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $jsonPayload,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json; charset=utf-8',
                'Accept: application/json'
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_TIMEOUT        => 25,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $curlResult = curl_exec($ch);
        $curlErrno  = curl_errno($ch);
        $curlError  = curl_error($ch);
        $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($curlErrno !== 0 || $curlResult === false) {
            error_log("Google Sheets cURL error ({$curlErrno}): {$curlError}");
            $sheetErrorMessage = 'Unable to reach the lead processing server. Please check network connectivity or try again.';
        } elseif ($httpCode >= 400) {
            error_log("Google Sheets HTTP error ({$httpCode}): {$curlResult}");
            $sheetErrorMessage = "Lead processing service returned HTTP status {$httpCode}.";
        } else {
            $parsedJson = json_decode($curlResult, true);
            if (!is_array($parsedJson)) {
                error_log("Google Sheets invalid JSON response: " . substr((string)$curlResult, 0, 300));
                $sheetErrorMessage = 'Invalid response received from the lead processing service.';
            } elseif (!empty($parsedJson['success']) && $parsedJson['success'] === true) {
                $sheetSuccess = true;
            } else {
                $rawMsg = $parsedJson['message'] ?? 'Lead submission rejected.';
                error_log("Google Sheets submission failure: {$rawMsg}");
                if (stripos($rawMsg, 'unauthorized') !== false) {
                    $sheetErrorMessage = 'Lead processing unauthorized: Please ensure GOOGLE_SHEETS_SECRET is configured in server environment.';
                } else {
                    $sheetErrorMessage = 'Lead processing error: ' . $rawMsg;
                }
            }
        }
    } else {
        // Fallback using stream context if cURL extension is not loaded
        $streamOptions = [
            'http' => [
                'method'          => 'POST',
                'header'          => "Content-Type: application/json; charset=utf-8\r\nAccept: application/json\r\nContent-Length: " . strlen($jsonPayload) . "\r\n",
                'content'         => $jsonPayload,
                'timeout'         => 25,
                'follow_location' => 1,
                'max_redirects'   => 5
            ]
        ];
        $streamContext = stream_context_create($streamOptions);
        $streamResult  = @file_get_contents($googleScriptUrl, false, $streamContext);

        if ($streamResult === false) {
            $sheetErrorMessage = 'Unable to connect to the lead processing server via HTTP stream.';
        } else {
            $parsedJson = json_decode($streamResult, true);
            if (is_array($parsedJson) && !empty($parsedJson['success']) && $parsedJson['success'] === true) {
                $sheetSuccess = true;
            } else {
                $rawMsg = $parsedJson['message'] ?? 'Submission rejected.';
                $sheetErrorMessage = 'Lead processing error: ' . $rawMsg;
            }
        }
    }

    // Check if Google Sheets submission succeeded
    if (!$sheetSuccess) {
        $response['success'] = false;
        $response['message'] = $sheetErrorMessage !== '' ? $sheetErrorMessage : 'Unable to record lead. Please try again.';
        echo json_encode($response);
        exit;
    }

    // Google Sheets confirmed success: Send notification email as backup
    $to = SITE_EMAIL;
    $subject = "New Confidential Lead from " . $name . " [" . ($service ?: 'General Inquiry') . "]";
    
    $emailBody  = "You have received a new confidential lead on your website (recorded to Google Sheets):\n\n";
    $emailBody .= "Name / Pseudonym: " . $name . "\n";
    $emailBody .= "Email: " . $email . "\n";
    $emailBody .= "Phone: " . $phone . "\n";
    $emailBody .= "Service Required: " . ($service ?: 'General Inquiry') . "\n";
    $emailBody .= "Timestamp: " . date('Y-m-d H:i:s T') . "\n\n";
    $emailBody .= "Confidential Details / Message:\n" . $message . "\n";

    $headers   = [];
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type: text/plain; charset=utf-8";
    $headers[] = "From: Cyber Kovai Website <noreply@" . ($_SERVER['HTTP_HOST'] ?? 'cyberkovai.com') . ">";
    $headers[] = "Reply-To: {$name} <{$email}>";

    @mail($to, $subject, $emailBody, implode("\r\n", $headers));

    $response['success'] = true;
    $response['message'] = 'Thank you! Your confidential enquiry has been received and recorded. Our team will contact you shortly.';
}

echo json_encode($response);
exit;