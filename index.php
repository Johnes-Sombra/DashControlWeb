<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
        exit();
    }
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