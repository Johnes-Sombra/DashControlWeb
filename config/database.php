<?php
class Database {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO('sqlite:../db/coopsul_db.db');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->db;
    }
}
define('DB_HOST', '192.168.1.41');
define('DB_PORT', '3306');

// Banco de dados de autenticação
define('AUTH_DB_NAME', 'auth_db');
define('AUTH_DB_USER', 'seu_usuario');
define('AUTH_DB_PASS', 'sua_senha');

// Banco de dados principal
define('MAIN_DB_NAME', 'coopsul_db');
define('MAIN_DB_USER', 'seu_usuario');
define('MAIN_DB_PASS', 'sua_senha');