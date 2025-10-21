<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

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

    public function enviarConfirmacion()
    {

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '5570d5dcdbd770';
        $mail->Password = '1f44f937c53ac0';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon', 'Appsalon.com');
    }
}
