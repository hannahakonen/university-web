<?php
//https://www.geeksforgeeks.org/how-to-send-an-email-using-phpmailer/
//TO BE MODIFIED?????
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//jukka
require __DIR__ . '/phpmailer/Exception.php'; //TOIMIIKO POLKU
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';

//require 'vendor/autoload.php'; Jukalta pois

function send_email($emailTo, $msg, $subject) {

    $mail = new PHPMailer(true);
    //jukan
    $emailFrom = "tuki@primea.fi";
    $emailFromName = "Opintopalvelu";
    $emailToName = "";

    try {
        //$mail->SMTPDebug = 2;
        $mail->Timeout = 10;  //jukan
        $mail->isSMTP();
        $mail->Host = "smtp.mailtrap.io"; //EMAIL_HOST;
        $mail->SMTPAuth = true; //geeks
        $mail->Username = "b0c3c20bfa097b"; //EMAIL_USERNAME, $username_mailtrap;
        $mail->Password = "30556fb9581fdf"; //EMAIL_PASSWORD, $password_mailtrap;
        $mail->CharSet = 'UTF-8'; //jukka
        $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages jukan
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525; //EMAIL_PORT; mailtrap, sengrid 587
        $mail->setFrom($emailFrom, $emailFromName); 
        $mail->addAddress($emailTo); //geeks
        $mail->addAddress($emailTo, $emailToName);
        $mail->isHTML(true);
        $mail->Subject = $subject; //'Subject'
        $mail->msgHTML($msg); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
        //$mail->Body = 'HTML message body in <b>bold</b> ';
        $mail->AltBody = 'HTML messaging not supported';
        //$mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
        echo "Mail has been sent successfully!";  //KATSO JUKAN ILMOT
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
