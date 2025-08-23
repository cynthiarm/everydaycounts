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

    $header = 'From: Every Day Counts Info <noreply@everydaycountservices.com>'. "\r\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $header .= "Mime-Version: 1.0" . "\r\n";
    $header .= "Content-Type: text/html; charset=UTF-8". "\r\n";

    $image = base64_encode(file_get_contents("img/logo/edcblanco-120x.png"));
    $logo = 'img/logo/edcblanco-120x.png';
    $link = 'https://everydaycountservices.com';

// SMTP configuration
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'everydaycountservices.com'; // Your SMTP server
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'noreply@everydaycountservices.com'; // SMTP username
    $mail->Password = 'Every20#25#'; // SMTP password
    $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, 'ssl' also accepted
    $mail->Port = 465; // SMTP port (typically 587 for TLS or 465 for SSL)
    $mail->CharSet    = 'UTF-8';

    // Sender and recipient details
    $mail->setFrom('noreply@everydaycountservices.com', 'Every Day Counts Info!');
    $mail->addAddress('info@everydaycountservices.com');

    // Email subject and body
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $subject;
    $type = isset($_POST["type"]) ? intval($_POST["type"]) : 2; // default inglés
    // Adjuntar el logo al correo
    $mail->AddEmbeddedImage(__DIR__ . "/img/logo/edcblanco-120x.png", "logoimg");

    if($type === 1){
        $template = file_get_contents(__DIR__ . '/emailbody-esp.html');
        $mail->Subject = "¡Alguien está tratando de comunicarse con usted!";
    } else {
        $template = file_get_contents(__DIR__ . '/emailbody-eng.html');
        $mail->Subject = "Someone is trying to reach you!";
    }

    // Reemplazar placeholders en la plantilla
    $mail->Body = str_replace(
        ["{{name}}", "{{email}}", "{{issue}}", "{{message}}"],
        [$name, $email, $issue, nl2br($message)],
        $template
    );

    // Enviar correo

    if($mail->send()) {
        echo ($type === 1) ? "OK_CONTACT_ES" : "OK_CONTACT_EN";
    } else {
        echo ($type === 1) ? "ERROR_CONTACT_ES" : "ERROR_CONTACT_EN";
    }

} catch (Exception $e) {
    echo ($type === 1) 
        ? "ERROR_CONTACT_ES" 
        : "ERROR_CONTACT_EN";
}
?>



