<?php
class Database {
    private $auth_db;
    private $main_db;

    public function __construct() {
        try {
            // Conexão com o banco de dados de autenticação
            $this->auth_db = new PDO(
                'mysql:host=localhost;dbname=' . AUTH_DB_NAME,
                'root',
                ''
            );
            $this->auth_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Conexão com o banco de dados principal
            $this->main_db = new PDO(
                'mysql:host=localhost;dbname=' . MAIN_DB_NAME,
                'root',
                ''
            );
            $this->main_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
    }

    public function getAuthConnection() {
        return $this->auth_db;
    }

    public function getMainConnection() {
        return $this->main_db;
    }
}

// Configurações do banco de dados
define('DB_HOST', 'localhost');

// Banco de dados de autenticação
define('AUTH_DB_NAME', 'auth_db');

// Banco de dados principal
define('MAIN_DB_NAME', 'coopsul_db');