<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class MailService {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        
        // Configurações do servidor de e-mail
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com'; // Altere para seu servidor SMTP
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'seu-email@gmail.com'; // Seu e-mail
        $this->mailer->Password = 'sua-senha-app'; // Sua senha
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
        $this->mailer->CharSet = 'UTF-8';
        
        // Configurações do remetente
        $this->mailer->setFrom('seu-email@gmail.com', 'Coopsul - Sistema');
    }

    public function enviarEmailRecuperacao($usuario, $email, $token) {
        try {
            $link = "http://" . $_SERVER['HTTP_HOST'] . "/redefinir_senha.php?token=" . $token;

            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Recuperação de Senha - Coopsul';
            $this->mailer->Body = "
                <h2>Recuperação de Senha</h2>
                <p>Olá {$usuario},</p>
                <p>Você solicitou a recuperação de senha. Clique no link abaixo para redefinir sua senha:</p>
                <p><a href='{$link}'>Clique aqui para redefinir sua senha</a></p>
                <p>Se você não solicitou esta recuperação, ignore este e-mail.</p>
                <p>Este link é válido por 1 hora.</p>
            ";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: " . $e->getMessage());
            return false;
        }
    }
}