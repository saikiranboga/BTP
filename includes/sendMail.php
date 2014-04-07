<?php

require_once 'includes/path.php';
require_once 'includes/' . $PHPMailer;

function sendMail($To, $Subject, $Body, $AltBody = 0) {
    if ($AltBody == 0) {
        $AltBody = $Body;
    }
    $mail = new PHPMailer;
//$mail->isSendmail();                                  // Set email format to sendmail
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com:587';  // Specify main and backup server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'metagen.noreply@gmail.com';                            // SMTP username
    $mail->Password = 'metagennoreply';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

    $mail->From = 'metagen.noreply@gmail.com';
    $mail->FromName = 'MetaGen';
    $mail->addAddress($To);  // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('metagen.noreply@gmail.com', 'MetaGen');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

    $mail->WordWrap = 80;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                // Set email format to HTML

    $mail->Subject = $Subject;
    $mail->Body = $Body;
//    $mail->AltBody = $AltBody;

    if (!$mail->send()) {
//        echo 'Message could not be sent.';
//        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
    }
//    echo 'Message sent successfully';
    return true;
}
