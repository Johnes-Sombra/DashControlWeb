<?php
session_start();

// Definir constantes do sistema
define('BASE_PATH', __DIR__);
define('BASE_URL', '/DashControlWeb'); // Corrigido para incluir o nome do projeto
require_once 'config/verificar_sessao.php';

// Função para limpar a URL
function limparUrl($url) {
    return filter_var(trim($url, '/'), FILTER_SANITIZE_URL);
}

// Obter a URL requisitada
$url = isset($_GET['url']) ? limparUrl($_GET['url']) : '';

// Definir rotas permitidas e seus requisitos de acesso
$rotas = [
    '' => ['arquivo' => 'views/dashboard.php', 'nivel' => 'usuario'],
    'login' => ['arquivo' => 'views/login.php', 'nivel' => 'publico'],
    'coletas' => ['arquivo' => 'views/coletas/index.php', 'nivel' => 'usuario'],
    'coletas/adicionar' => ['arquivo' => 'views/coletas/adicionar.php', 'nivel' => 'usuario'],
    'coletas/locais' => ['arquivo' => 'views/coletas/locais.php', 'nivel' => 'usuario'],
    'coletas/veiculos' => ['arquivo' => 'views/coletas/veiculos.php', 'nivel' => 'usuario'],
    'coletas/relatorio' => ['arquivo' => 'views/coletas/relatorio.php', 'nivel' => 'usuario'],
    'admin' => ['arquivo' => 'views/admin/index.php', 'nivel' => 'admin'],
    'admin/usuarios' => ['arquivo' => 'views/admin/usuarios.php', 'nivel' => 'admin'],
];

// Verificar se a rota existe
if (!array_key_exists($url, $rotas)) {
    header('HTTP/1.0 404 Not Found');
    include 'views/404.php';
    exit;
}

// Verificar nível de acesso necessário
$rota = $rotas[$url];
if ($rota['nivel'] !== 'publico') {
    if ($rota['nivel'] === 'admin') {
        verificarAdmin();
    } else {
        verificarSessao();
    }
}

// Incluir o template header
include 'views/templates/header.php';

// Carregar o arquivo da rota
if (file_exists(BASE_PATH . '/' . $rota['arquivo'])) {
    include BASE_PATH . '/' . $rota['arquivo'];
} else {
    include 'views/404.php';
}

// Incluir o template footer
include 'views/templates/footer.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/assets/logos/coopsul.ico">
    <link rel="stylesheet" href="./assets/css/main-style.css">
    <title>Dash Control Web | Cooperativa Coopsul</title>
    <style>
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: #1B5E20;
            padding: 20px;
            position: fixed;
            height: 100vh;
            color: white;
        }
        
        .sidebar .logo {
            width: 150px;
            height: auto;
            margin: 0 auto 30px;
            display: block;
        }
        
        .content-area {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .menu-container {
            width: 100%;
        }
        
        .menu-button {
            display: block;
            margin-bottom: 10px;
            background-color: #2E7D32;
            transition: background-color 0.3s;
        }
        
        .menu-button:hover {
            background-color: #388E3C;
        }
        
        .sair-button {
            position: absolute;
            bottom: 20px;
            width: calc(100% - 40px);
            background-color: #9b7306;
            color: white;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        
        .header {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <img src="./assets/logos/coopsul.png" alt="Logo Coopsul" class="logo">
            <div class="menu-container">
                <a href="./coletas" class="menu-button">Coletas</a>
                <a href="./cooperados" class="menu-button">Cooperados</a>
                <a href="./empresas" class="menu-button">Empresas</a>
                <a href="./logout.php" class="sair-button">Sair</a>
            </div>
        </div>
        
        <div class="content-area">
            <div class="header">
                <h1>Painel Administrativo</h1>
            </div>
            <div id="main-content">
                <!-- Conteúdo dinâmico será carregado aqui -->
                <h2>Bem-vindo ao Sistema de Gestão Coopsul</h2>
                <p>Selecione uma opção no menu lateral para começar.</p>
            </div>
        </div>
    </div>
</body>
</html>