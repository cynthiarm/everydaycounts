<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configuración SMTP GoDaddy Workspace
    $mail->isSMTP();
    $mail->Host       = 'smtpout.secureserver.net'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = 'noreply@everydaycountservices.com'; 
    $mail->Password   = 'Every20#25#'; 
    $mail->SMTPSecure = 'ssl'; // o tls
    $mail->Port       = 465;   // si falla, prueba 587 con tls

    // Debug para ver errores
    $mail->SMTPDebug  = 2; 
    $mail->Debugoutput = 'html';

    // Remitente (debe ser el mismo que el Username)
    $mail->setFrom('noreply@everydaycountservices.com', 'Every Day Counts');

    // Destinatario de prueba
    $mail->addAddress('crenteria@deviseis.com', 'Prueba Gmail');

    // Contenido
    $mail->isHTML(false);
    $mail->Subject = "Prueba de correo desde GoDaddy SMTP";
    $mail->Body    = "¡Hola! Este es un correo de prueba enviado con PHPMailer y GoDaddy Workspace.";

    // Enviar
    if ($mail->send()) {
        echo "✅ Correo enviado correctamente";
    } else {
        echo "❌ Error al enviar: {$mail->ErrorInfo}";
    }

} catch (Exception $e) {
    echo "❌ Error de excepción: {$mail->ErrorInfo}";
}