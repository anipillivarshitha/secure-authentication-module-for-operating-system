<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@gmail.com'; 
    $mail->Password = 'your-email-password'; 
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('your-email@gmail.com', '2FA System');
    $mail->addAddress($_SESSION['email']);

    $mail->isHTML(true);
    $mail->Subject = "Your OTP Code";
    $mail->Body = "Your OTP code is <b>" . $_SESSION['otp'] . "</b>. This code expires in 5 minutes.";

    $mail->send();
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
