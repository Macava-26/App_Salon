<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    private function configurarMailer()
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '401a2bdd3d3720';
        $mail->Password = 'd3c4a8e65b3462';

        // Configuración de seguridad
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPDebug = 0; // Debug desactivado

        // Timeout más largo para la conexión
        $mail->Timeout = 30;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'appsalon.com');
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        return $mail;
    }

    public function enviarConfirmacion()
    {
        $mail = $this->configurarMailer();
        $mail->Subject = 'Confirma tu Cuenta';


        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta, da click en el siguiente enlace: </p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta </a> </p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;


        $mail->send();
        // debuguear($mail);
    }

    public function enviarInstrucciones()
    {
        $mail = $this->configurarMailer();
        $mail->Subject = 'Restablece tu Password';


        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado restablecer tu password, haz click en el siguiente enlace:  </p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'> Restablecer Password </a> </p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;


        $mail->send();
    }
}
