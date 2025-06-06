<?php
class Database {
    private static $authInstance = null;
    private static $mainInstance = null;

    // Conexão com o banco de autenticação
    public static function getAuthConnection() {
        if (self::$authInstance === null) {
            try {
                $dsn = sprintf(
                    "mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4",
                    DB_HOST,
                    DB_PORT,
                    AUTH_DB_NAME
                );
                
                self::$authInstance = new PDO(
                    $dsn,
                    AUTH_DB_USER,
                    AUTH_DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    ]
                );
            } catch (PDOException $e) {
                die("Erro na conexão com banco de autenticação: " . $e->getMessage());
            }
        }
        return self::$authInstance;
    }

    // Conexão com o banco principal
    public static function getMainConnection() {
        if (self::$mainInstance === null) {
            try {
                $dsn = sprintf(
                    "mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4",
                    DB_HOST,
                    DB_PORT,
                    MAIN_DB_NAME
                );
                
                self::$mainInstance = new PDO(
                    $dsn,
                    MAIN_DB_USER,
                    MAIN_DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    ]
                );
            } catch (PDOException $e) {
                die("Erro na conexão com banco principal: " . $e->getMessage());
            }
        }
        return self::$mainInstance;
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