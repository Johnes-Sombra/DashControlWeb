<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/assets/logos/coopsul.ico">
    <link rel="stylesheet" href="/assets/css/main-style.css">
    <title>Dash Control Web | Cooperativa Coopsul</title>
    <!-- Adicionar após os links CSS existentes -->
    <script src="/assets/js/notifications.js"></script>
    <script src="/assets/js/confirm-dialog.js"></script>
</head>
<body>
    <?php if (isset($_SESSION['usuario']) && $rota['nivel'] !== 'publico'): ?>
    <div class="admin-container">
        <div class="sidebar">
            <img src="/assets/logos/coopsul.png" alt="Logo Coopsul" class="logo">
            <div class="menu-container">
                <a href="/coletas" class="menu-button">Coletas</a>
                <a href="/cooperados" class="menu-button">Cooperados</a>
                <a href="/empresas" class="menu-button">Empresas</a>
                <?php if ($_SESSION['nivel_acesso'] === 'admin'): ?>
                <a href="/admin" class="menu-button">Administração</a>
                <?php endif; ?>
                <a href="/logout.php" class="sair-button">Sair</a>
            </div>
        </div>
        <div class="content-area">
    <?php endif; ?>