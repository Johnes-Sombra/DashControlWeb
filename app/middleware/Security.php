<?php
class Security {
    public static function sanitizeInput($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitizeInput($value);
            }
        } else {
            $data = htmlspecialchars(strip_tags($data));
        }
        return $data;
    }

    public static function validateCSRF() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || 
                $_SESSION['csrf_token'] !== $_POST['csrf_token']) {
                header('HTTP/1.1 403 Forbidden');
                die('Acesso negado');
            }
        }
    }

    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateSession() {
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
            session_unset();
            session_destroy();
            header('Location: /login');
            exit;
        }
        $_SESSION['last_activity'] = time();
    }

    public static function preventSQLInjection($value) {
        if (is_numeric($value)) {
            return $value;
        }
        return preg_replace('/[^A-Za-z0-9\-_]/', '', $value);
    }
}