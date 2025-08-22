<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    $subscriberEmail = 'cynthia.remo21@gmail.com'; // reemplaza con el correo del suscriptor
    if(empty($subscriberEmail)){
        echo "ERROR: Email vacío";
        exit;
    }

    // Configuración SMTP GoDaddy
    $mail->isSMTP();
    $mail->Host       = 'smtp.secureserver.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'noreply@everydaycountservices.com'; // tu cuenta de correo GoDaddy
    $mail->Password   = 'Every20#25#'; // tu contraseña
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    // Remitente y destinatario
    $mail->setFrom('noreply@everydaycountservices.com', 'Every Day Counts');
    $mail->addAddress($subscriberEmail);
    $mail->addReplyTo('info@everydaycountservices.com', 'Every Day Counts');

    // Contenido del correo (texto plano)
    $mail->isHTML(false);
    $mail->Subject = "Prueba Newsletter";
    $mail->Body    = "Hola, esta es una prueba de suscripción. Si recibes este correo, el SMTP funciona correctamente.";

    if($mail->send()){
        echo "Correo enviado correctamente a $subscriberEmail";
    } else {
        echo "Error al enviar: {$mail->ErrorInfo}";
    }

} catch (Exception $e) {
    echo "Excepción al enviar: {$mail->ErrorInfo}";
}
?>
