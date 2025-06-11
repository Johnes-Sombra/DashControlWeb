<?php
require_once 'config.php';

class Database {
    private $auth_db;
    private $main_db;
    private static $max_login_attempts = 3;
    private static $lockout_time = 900; // 15 minutos em segundos

    public function __construct() {
        try {
            // Conexão com o banco de dados de autenticação
            $this->auth_db = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . AUTH_DB_NAME . ';charset=utf8',
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ]
            );

            // Conexão com o banco de dados principal
            $this->main_db = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . MAIN_DB_NAME . ';charset=utf8',
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ]
            );

        } catch(PDOException $e) {
            error_log("Erro na conexão: " . $e->getMessage());
            throw new Exception("Erro ao conectar ao banco de dados");
        }
    }

    public function getAuthConnection() {
        return $this->auth_db;
    }

    public function getMainConnection() {
        return $this->main_db;
    }

    // Novo método para verificar tentativas de login
    public function checkLoginAttempts($usuario) {
        $stmt = $this->auth_db->prepare(
            "SELECT attempts, last_attempt, locked_until 
             FROM login_attempts 
             WHERE usuario = ?"
        );
        $stmt->execute([$usuario]);
        $result = $stmt->fetch();

        if (!$result) {
            return true; // Primeiro login
        }

        if ($result['locked_until'] > time()) {
            return false; // Usuário bloqueado
        }

        return $result['attempts'] < self::$max_login_attempts;
    }

    // Novo método para registrar tentativa de login
    public function recordLoginAttempt($usuario, $success) {
        if ($success) {
            $sql = "DELETE FROM login_attempts WHERE usuario = ?";
            $this->auth_db->prepare($sql)->execute([$usuario]);
            return;
        }

        $sql = "INSERT INTO login_attempts (usuario, attempts, last_attempt, locked_until) 
                VALUES (?, 1, NOW(), NOW() + INTERVAL ? SECOND) 
                ON DUPLICATE KEY UPDATE 
                attempts = attempts + 1,
                last_attempt = NOW(),
                locked_until = IF(attempts + 1 >= ?, NOW() + INTERVAL ? SECOND, locked_until)";

        $this->auth_db->prepare($sql)->execute([
            $usuario,
            self::$lockout_time,
            self::$max_login_attempts,
            self::$lockout_time
        ]);
    }

    // Novo método para registrar logs de acesso
    public function logAccess($usuario, $acao, $status) {
        $sql = "INSERT INTO access_logs (usuario, acao, status, ip_address, data_hora) 
                VALUES (?, ?, ?, ?, NOW())";
        $this->auth_db->prepare($sql)->execute([
            $usuario,
            $acao,
            $status,
            $_SERVER['REMOTE_ADDR']
        ]);
    }
}
