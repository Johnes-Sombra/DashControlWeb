<?php
require_once __DIR__ . '/../app/middleware/Auth.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controller = isset($url[0]) && $url[0] !== '' ? ucfirst($url[0]) . 'Controller' : 'AuthController';
$method = isset($url[1]) ? $url[1] : 'login';

// Rotas públicas
$public_routes = ['login'];

// Verificar autenticação exceto para rotas públicas
if (!in_array($method, $public_routes)) {
    Auth::check();
}

$controller_path = __DIR__ . "/../app/controllers/{$controller}.php";

if (file_exists($controller_path)) {
    require_once $controller_path;
    $controller = new $controller();
    
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        header('HTTP/1.1 404 Not Found');
        echo '404 - Método não encontrado';
    }
} else {
    header('HTTP/1.1 404 Not Found');
    echo '404 - Controlador não encontrado';
}