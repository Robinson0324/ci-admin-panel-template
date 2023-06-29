<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PHPMailer - sendmail test</title>
</head>
<body>
<?php
require '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
// Set PHPMailer to use the sendmail transport
$mail->isSendmail();
//Set who the message is to be sent from
$mail->setFrom('wjsskanyo@gmail.com', 'gmail mail');
//Set an alternative reply-to address
$mail->addReplyTo('wjsskanyo@163.com', '163 mail');
//Set who the message is to be sent to
$mail->addAddress('wjsskanyo@hotmail.com', 'wjsskanyo hotmail is right?');
//Set the subject line
$mail->Subject = 'PHPMailer sendmail test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
print_r("where?");
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;	
} else {
    echo "Message sent!";	
}
?>
</body>
</html>
