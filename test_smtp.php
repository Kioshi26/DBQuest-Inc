<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load config
if (!file_exists('config.php')) {
    die("Error: config.php not found.");
}
$config = require 'config.php';

// Load PHPMailer
require 'phpmailer/PHPMailer-master/src/Exception.php';
require 'phpmailer/PHPMailer-master/src/PHPMailer.php';
require 'phpmailer/PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

echo "<h1>SMTP Connection Test</h1>";
echo "<p>Attempting to connect to <strong>{$config['SMTP_HOST']}</strong> as <strong>{$config['SMTP_USER']}</strong>...</p>";

try {
    // Enable verbose debug output
    $mail->SMTPDebug = 2; // 2 = client and server messages
    $mail->isSMTP();
    $mail->Host = $config['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['SMTP_USER'];
    $mail->Password = $config['SMTP_PASS'];
    $mail->SMTPSecure = $config['SMTP_SECURE'];
    $mail->Port = $config['SMTP_PORT'];

    //Timout setting
    $mail->Timeout = 10;

    // Just check connection
    if ($mail->smtpConnect()) {
        echo "<h2 style='color:green'>SUCCESS: Connected and Authenticated!</h2>";
        $mail->smtpClose();
    } else {
        echo "<h2 style='color:red'>FAILED: Could not connect/authenticate.</h2>";
    }

} catch (Exception $e) {
    echo "<h2 style='color:red'>ERROR: " . $e->getMessage() . "</h2>";
}
?>