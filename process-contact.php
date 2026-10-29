<?php
/**
 * Cyber Kovai - Contact Form Processor with reCAPTCHA Verification
 */

require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

$response = [
    'success' => false,
    'message' => 'Invalid request method.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name              = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email             = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone             = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $service           = filter_input(INPUT_POST, 'service', FILTER_SANITIZE_SPECIAL_CHARS) 
                         ?: filter_input(INPUT_POST, 'service_interest', FILTER_SANITIZE_SPECIAL_CHARS);
    $message           = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    // Verify reCAPTCHA token
    if (empty($recaptchaResponse)) {
        $response['message'] = 'Please complete the reCAPTCHA verification.';
        echo json_encode($response);
        exit;
    }

    $secretKey = defined('RECAPTCHA_SECRET_KEY') ? RECAPTCHA_SECRET_KEY : '';
    $captchaValid = false;

    if (!empty($secretKey)) {
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $postData = [
            'secret'   => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
        ];

        if (function_exists('curl_init')) {
            $ch = curl_init($verifyUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
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
    }

    if (!$captchaValid) {
        $response['message'] = 'reCAPTCHA verification failed. Please try again.';
        echo json_encode($response);
        exit;
    }

    if (empty($name)) {
        $response['message'] = 'Please enter your name.';
    } elseif (!$email) {
        $response['message'] = 'Please provide a valid email address.';
    } elseif (empty($phone)) {
        $response['message'] = 'Please provide your contact number.';
    } elseif (empty($message)) {
        $response['message'] = 'Please write a message describing your inquiry.';
    } else {
        // Build email headers and body
        $to = SITE_EMAIL;
        $subject = "New Inquiry from " . $name . " [" . ($service ?: 'General Inquiry') . "]";
        
        $emailBody  = "You have received a new contact submission from your website:\n\n";
        $emailBody .= "Name: " . $name . "\n";
        $emailBody .= "Email: " . $email . "\n";
        $emailBody .= "Phone: " . $phone . "\n";
        $emailBody .= "Service Requested: " . ($service ?: 'General Inquiry') . "\n\n";
        $emailBody .= "Message:\n" . $message . "\n";

        $headers   = [];
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/plain; charset=utf-8";
        $headers[] = "From: Cyber Kovai Website <noreply@" . ($_SERVER['HTTP_HOST'] ?? 'cyberkovai.com') . ">";
        $headers[] = "Reply-To: {$name} <{$email}>";

        // Try to send mail using PHP mail() function
        $mailSent = @mail($to, $subject, $emailBody, implode("\r\n", $headers));

        $response['success'] = true;
        $response['message'] = 'Thank you! Your confidential enquiry has been received. Our team will contact you shortly.';
    }
}

echo json_encode($response);
exit;
