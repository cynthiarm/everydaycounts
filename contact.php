<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


// Include the PHPMailer Autoload file
//require 'PHPMailer/PHPMailerAutoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {

// Set mailer to use SMTP

    $type = $_POST['type']; //1--> spanish, 2--> english
    $name = $_POST['name'];
    $emailTo = $_POST['email'];
    $email = $_POST['email'];
    $issue = $_POST['issue'];
    $subject = $_POST['subject'];
    $bodyEmail = $_POST['message'];

    $hello = '';
    $emailLang = '';
    $nameLang = '';
    $issueLang = '';
    $messageLang = '';
    $subjectLang = '';
    $subject = '';
    $headers = '';

    $hello = 'Hello';
    $emailLang = 'Email:';
    $nameLang = 'Name:';
    $issueLang = 'Subject:';
    $subjectLang = '';
    $messageLang = 'Message:';

    if($type == '1' )
    {
        $hello = 'Hola';
        $emailLang = 'Correo Electrónico:';
        $subject = '¡Alguien está tratando de comunicarse con usted a través de su sitio web de Every Day Counts!';
        $fromname = "¡Alguien está tratando de comunicarse con usted a través de su sitio web de Every Day Counts!";      

    }
    else if($type == '2'){
        $hello = 'Hello';
        $emailLang = 'Email:';
        $subject = 'Someone is trying to reach you by using your Every Day Counts website!';
        $fromname = "Someone is trying to reach you by using your Every Day Counts website!";       
    }

    
    $header = 'From: CYD Global Info <info@cyd-global.com>'. "\r\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $header .= "Mime-Version: 1.0" . "\r\n";
    $header .= "Content-Type: text/html; charset=UTF-8". "\r\n";

    $image = base64_encode(file_get_contents("assets/images/logo/Logo SG 120x120.png"));
    $logo = 'assets/images/logo/Logo SG 120x120.png';
    $link = 'https://cyd-global.com/';

// SMTP configuration
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'cyd-global.com'; // Your SMTP server
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'info@cyd-global.com'; // SMTP username
    $mail->Password = 'Info20#24#'; // SMTP password
    $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, 'ssl' also accepted
    $mail->Port = 465; // SMTP port (typically 587 for TLS or 465 for SSL)

    // Sender and recipient details
    $mail->setFrom('info@cyd-global.com', 'CYD Global Info!');
    $mail->addAddress('crenteria@deviseis.com');

    // Email subject and body
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = '<html><body>';
    $mail->Body .= "<a href='{$link}'><img src='{$logo}' alt=''></a><br><br>";
    $mail->Body .= "<h1>$hello</h1>";
    $mail->Body .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
    $mail->Body .= "<tr style='background: #EDFAFD;'><td align='right'><strong>$nameLang</strong> </td><td>" . $name . "</td></tr>";
    $mail->Body .= "<tr><td align='right'><strong> $emailLang</strong> </td><td>" . $email . "</td></tr>";
    $mail->Body .= "<tr style='background: #EDFAFD;'><td align='right'><strong>$issueLang</strong> </td><td>". $issue . "</td></tr>";
    $mail->Body .= "<tr><td align='right'><strong>$messageLang</strong> </td><td>" .  trim($_POST["message"]) . "</td></tr>";
    $mail->Body .= "</table>";
    $mail->Body .= "</body></html>";

    $mail->CharSet = 'UTF-8';
    $mail->send();
    // Send email

    if(!$mail->send()){
        if($type == '1' ){
            error_log("<div style='color: #8f8a8a;text-align: left;margin-left: 20px;font-size: 16px;font-family: Helvetica Neue, Helvetica, Arial, sans-serif;'> No se pudo enviar el correo! " . $mail->ErrorInfo); die();
        }
        else if($type == '2'){
            error_log("<div style='color: #8f8a8a;text-align: left;margin-left: 20px;font-size: 16px;font-family: Helvetica Neue, Helvetica, Arial, sans-serif;'>Message could not be sent." .  $mail->ErrorInfo);die();
        }    
    } 
    if($type == '1' ){
            echo "<div style='color: #8f8a8a;text-align: left;margin-left: 20px;font-size: 16px;font-family: Helvetica Neue, Helvetica, Arial, sans-serif;'>Mensaje enviado correctamente."; die();
    }
    else if($type == '2'){
        echo "<html>";
        echo "<div style='color: #8f8a8a;text-align: left;margin-left: 20px;font-size: 16px;font-family: Helvetica Neue, Helvetica, Arial, sans-serif;'>Your message has been sent."; die();
    }

} catch (Exception $e) {

}
?>

