<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir los archivos de PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $mensaje = htmlspecialchars($_POST['message']);

    // Configuración del servidor SMTP
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth   = true;
        $mail->Username   = ''; // Cambia por tu correo
        $mail->Password   = ''; // Clave de aplicación de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Configuración del remitente y destinatario
        $mail->setFrom($email, $nombre);
        $mail->addAddress(''); // Cambia al correo destinatario

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Beauty Parlor - New message';
        $mail->Body    = "
            <html>
            <body>
                <h1>Mensaje de: $nombre</h1>
                <p><strong>Correo electrónico:</strong> $email</p>
                <p><strong>Mensaje:</strong><br>" . nl2br($mensaje) . "</p>
            </body>
            </html>";

        // Enviar correo
        if ($mail->send()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Solicitud inválida']);
}
?>