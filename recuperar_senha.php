<?php
require_once 'config/database.php';

class PasswordRecovery {
    private $db;
    private static $token_expiry = 3600; // 1 hora em segundos

    public function __construct() {
        $this->db = new Database();
    }

    public function requestReset($usuario) {
        $conn = $this->db->getAuthConnection();
        
        // Verificar se o usuário existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        if (!$stmt->fetch()) {
            return false;
        }

        // Gerar token único
        $token = bin2hex(random_bytes(32));
        $now = new DateTime();
        $expires = (new DateTime())->add(new DateInterval('PT1H'));

        // Salvar token
        $stmt = $conn->prepare(
            "INSERT INTO password_resets 
             (usuario, token, created_at, expires_at) 
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $usuario,
            $token,
            $now->format('Y-m-d H:i:s'),
            $expires->format('Y-m-d H:i:s')
        ]);

        // Aqui você implementaria o envio do email com o link de recuperação
        // $resetLink = "https://seusite.com/redefinir_senha.php?token=" . $token;
        
        return $token;
    }

    public function validateToken($token) {
        $conn = $this->db->getAuthConnection();
        $stmt = $conn->prepare(
            "SELECT usuario FROM password_resets 
             WHERE token = ? 
             AND expires_at > NOW() 
             AND used = FALSE"
        );
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function resetPassword($token, $newPassword) {
        $conn = $this->db->getAuthConnection();
        $userData = $this->validateToken($token);
        
        if (!$userData) {
            return false;
        }

        // Atualizar senha
        $stmt = $conn->prepare(
            "UPDATE usuarios 
             SET senha = ? 
             WHERE usuario = ?"
        );
        $success = $stmt->execute([
            password_hash($newPassword, PASSWORD_DEFAULT),
            $userData['usuario']
        ]);

        if ($success) {
            // Marcar token como usado
            $conn->prepare(
                "UPDATE password_resets 
                 SET used = TRUE 
                 WHERE token = ?"
            )->execute([$token]);
        }

        return $success;
    }
}