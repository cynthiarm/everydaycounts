<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Captura de campos
    $type  = isset($_POST['type']) ? intval($_POST['type']) : 1; // 1=ES, 2=EN
    $email = isset($_POST['newsletter_email']) ? trim($_POST['newsletter_email']) : '';

    if(empty($email)){
        echo ($type === 1) ? "Por favor, ingrese un correo electrónico." : "Please enter an email address.";
        exit;
    }

    // Configuración SMTP con debug
    $mail->isSMTP();
    $mail->SMTPDebug  = 0; // 0=off, 2=debug
    $mail->Debugoutput = 'html';
    $mail->Host       = 'everydaycountservices.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'noreply@everydaycountservices.com';
    $mail->Password   = 'Every20#25#';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    // Remitente y destinatario
    $mail->setFrom('noreply@everydaycountservices.com', 'Every Day Counts');
    $mail->addAddress($email); // enviarlo al suscriptor
    $mail->addReplyTo('info@everydaycountservices.com', 'Every Day Counts');
    
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->AddEmbeddedImage(__DIR__ . '/img/logo/edcblanco-120x.png', 'logoimg');

    // Plantilla según idioma
    if ($type === 1) {
        $template = file_get_contents(__DIR__ . '/newsletter_welcome_es.html');
        $mail->Subject = "🎉 ¡Gracias por suscribirte a Every Day Counts!";
        $defaultName = "Amigo";
    } else {
        $template = file_get_contents(__DIR__ . '/newsletter_welcome_en.html');
        $mail->Subject = "🎉 Thanks for subscribing to Every Day Counts!";
        $defaultName = "Friend";
    }

    // Reemplazar variables dinámicas
    $replacements = [
        '{{logo_src}}'       => 'cid:logoimg',
        '{{brand_name}}'     => 'Every Day Counts',
        '{{name}}'           => $defaultName,
        '{{cta_url}}'        => 'https://www.everydaycountservices.com/',
        '{{year}}'           => date('Y'),
        '{{unsubscribe_url}}'=> 'https://www.everydaycountservices.com/unsubscribe'
    ];

    $mail->Body = str_replace(array_keys($replacements), array_values($replacements), $template);


    // Enviar correo
    if($mail->send()){
        echo ($type === 1) ? "OK_NEWSLETTER_ES" : "OK_NEWSLETTER_EN";
    } else {
        echo ($type === 1) ? "❌ Error al enviar el correo." : "❌ Error sending email.";
    }

} catch (Exception $e) {
    echo ($type === 1) ? "❌ Error al enviar: {$mail->ErrorInfo}" : "❌ Sending error: {$mail->ErrorInfo}";
}


?>
