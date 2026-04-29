<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

header('Content-Type: application/json');

// Check if captcha is set and correct
if (!isset($_POST['captcha']) || !isset($_SESSION['captcha']) || strtolower($_POST['captcha']) !== strtolower($_SESSION['captcha'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Security Code. Please try again.']);
    exit;
}

// Adjust paths to your PHPMailer location
require 'phpmailer/PHPMailer-master/src/Exception.php';
require 'phpmailer/PHPMailer-master/src/PHPMailer.php';
require 'phpmailer/PHPMailer-master/src/SMTP.php';

// Load configuration
$config = require 'config.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = $config['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['SMTP_USER'];
    $mail->Password = $config['SMTP_PASS'];
    $mail->SMTPSecure = $config['SMTP_SECURE'];
    $mail->Port = $config['SMTP_PORT'];

    //Recipients
    $email = $_POST['email'] ?? '';
    $name = $_POST['fullname'] ?? 'Web User';

    $mail->setFrom($email, $name);

    // You might want to send TO yourself, not TO the user who filled the form (unless it's an auto-reply).
    // The original mail.php sent TO 'teoxondave423@gmail.com' (the site owner)
    // You can also use $config['SMTP_USER'] here or a separate config for destination
    $mail->addAddress($config['SMTP_USER']);
    $mail->addReplyTo($email, $name);

    // CC self if requested
    if (isset($_POST['copy'])) {
        $mail->addCC($email);
    }

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Inquiry from ' . $name . ': ' . ($_POST['subject'] ?? 'No Subject');

    $body = "<h2>New Inquiry</h2>";
    $body .= "<p><strong>Role:</strong> " . htmlspecialchars($_POST['role'] ?? '') . "</p>";
    $body .= "<p><strong>Company:</strong> " . htmlspecialchars($_POST['company'] ?? '') . "</p>";
    $body .= "<p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>";
    $body .= "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    $body .= "<p><strong>Phone:</strong> " . htmlspecialchars($_POST['phone'] ?? '') . "</p>";
    $body .= "<p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($_POST['message'] ?? '')) . "</p>";

    $mail->Body = $body;
    $mail->AltBody = strip_tags($body);

    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
}
?>