<?php
require_once 'config.php';

class Database {
    private $auth_db;
    private $main_db;
    private static $max_login_attempts = 3;
    private static $lockout_time = 900; // 15 minutos em segundos
    private static $sqlite_path = __DIR__ . '/auth.sqlite';

    public function __construct() {
        try {
            // Conexão com o banco SQLite para autenticação
            $this->auth_db = new PDO(
                'sqlite:' . self::$sqlite_path,
                null,
                null,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            // Criar tabelas se não existirem
            $this->initializeSQLiteTables();

            // Conexão com o banco de dados principal (mantém MySQL)
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

    private function initializeSQLiteTables() {
        // Criar tabela de usuários
        $this->auth_db->exec("CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario TEXT NOT NULL UNIQUE,
            senha TEXT NOT NULL,
            nome_completo TEXT,
            email TEXT,
            nivel_acesso TEXT DEFAULT 'usuario',
            ativo INTEGER DEFAULT 1,
            data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        // Criar tabela de tentativas de login
        $this->auth_db->exec("CREATE TABLE IF NOT EXISTS login_attempts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario TEXT NOT NULL UNIQUE,
            attempts INTEGER DEFAULT 0,
            last_attempt DATETIME,
            locked_until DATETIME
        )");

        // Criar tabela de logs de acesso
        $this->auth_db->exec("CREATE TABLE IF NOT EXISTS access_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario TEXT NOT NULL,
            acao TEXT NOT NULL,
            status TEXT NOT NULL,
            ip_address TEXT,
            data_hora DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        // Inserir usuário admin padrão se não existir
        $stmt = $this->auth_db->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = 'adamastor'");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $this->auth_db->exec("INSERT INTO usuarios (usuario, senha, nivel_acesso) 
                VALUES ('adamastor', '" . password_hash('senha123', PASSWORD_DEFAULT) . "', 'admin')");
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

        $current_time = date('Y-m-d H:i:s');
        $locked_until = date('Y-m-d H:i:s', time() + self::$lockout_time);

        // Verificar se o usuário já existe
        $stmt = $this->auth_db->prepare("SELECT attempts FROM login_attempts WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $result = $stmt->fetch();

        if (!$result) {
            // Inserir novo registro
            $sql = "INSERT INTO login_attempts (usuario, attempts, last_attempt, locked_until) 
                    VALUES (?, 1, ?, ?)";
            $this->auth_db->prepare($sql)->execute([
                $usuario,
                $current_time,
                $locked_until
            ]);
        } else {
            // Atualizar registro existente
            $new_attempts = $result['attempts'] + 1;
            $sql = "UPDATE login_attempts 
                    SET attempts = ?, 
                        last_attempt = ?, 
                        locked_until = ? 
                    WHERE usuario = ?";
            $this->auth_db->prepare($sql)->execute([
                $new_attempts,
                $current_time,
                $new_attempts >= self::$max_login_attempts ? $locked_until : null,
                $usuario
            ]);
        }
    }

    // Novo método para registrar logs de acesso
    public function logAccess($usuario, $acao, $status) {
        $current_time = date('Y-m-d H:i:s');
        $sql = "INSERT INTO access_logs (usuario, acao, status, ip_address, data_hora) 
                VALUES (?, ?, ?, ?, ?)";
        $this->auth_db->prepare($sql)->execute([
            $usuario,
            $acao,
            $status,
            $_SERVER['REMOTE_ADDR'],
            $current_time
        ]);
    }
}
