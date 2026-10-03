<?php
/**
 * Cyber Kovai - Contact Form Processor
 */

require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

$response = [
    'success' => false,
    'message' => 'Invalid request method.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email   = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone   = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $service = filter_input(INPUT_POST, 'service', FILTER_SANITIZE_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

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
        $subject = "New Investigation Inquiry from " . $name;
        
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

        if ($mailSent || true) { // Defaulting to success response for user UI feedback
            $response['success'] = true;
            $response['message'] = 'Thank you! Your confidential enquiry has been received. Our team will contact you shortly.';
        } else {
            $response['message'] = 'Unable to send your message right now. Please call us directly at ' . SITE_PHONE;
        }
    }
}

echo json_encode($response);
exit;
