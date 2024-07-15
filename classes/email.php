<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token = NULL)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token ;
    }

    public function enviarEmail($tipo){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->isHTML(TRUE);
        $mail->SMTPSecure = 'tls';
        $mail->CharSet = 'UTF-8';

        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('usuario@usuario.com', 'userName');
        
        if($tipo === 'confirmacion'){
            $mail->Subject = 'Confirma tu cuenta';
            $contenido = "<html>";
            $contenido .= "<p> <strong> Hola " . $this->nombre . "</strong> has creado tu cuenta de app Salon, solo debes confirarla presionando en el siguiente enlace: </p>";
            $contenido .= "<a href='". $_ENV['APP_URL'] ."/confirmar-cuenta?token=". $this->token ."'> Confirmar cuenta </a> ";
            $contenido .= "<p> si tu no solicitaste esta cuenta, puedes ignorar el mensaje </p>";
            $contenido .= "</html>";
    
            $mail->Body = $contenido;
            $mail->send();
        }
        else if($tipo === 'olvide'){
            $mail->Subject = 'Recupera tu cuenta...';
            $contenido = "<html>";
            $contenido .= "<p> <strong> Hola " . $this->nombre . "</strong> has solicitado recuperar tu cuenta, crea una nueva password presionando en el siguiente enlace: </p>";
            $contenido .= "<a href='". $_ENV['APP_URL'] ."/recuperar?token=". $this->token ."'> Reestablece tu password </a> ";
            $contenido .= "<p> si tu no solicitaste esta cuenta, puedes ignorar el mensaje </p>";
            $contenido .= "</html>";

            $mail->Body = $contenido;
            $mail->send();
        }

    }
    

}