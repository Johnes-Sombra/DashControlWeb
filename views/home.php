<?php
require_once '../config/verificar_sessao.php';
require_once './templates/header.php';
?>
<img src="/assets/logos/coopsul.png" alt="Logo Coopsul" class="logo">
<div class="menu-container">
    <a href="/coletas" class="menu-button">Coletas</a>
    <a href="/cooperados" class="menu-button">Cooperados</a>
    <a href="/empresas" class="menu-button">Empresas</a>
    <a href="/logout" class="sair-button">Sair</a>
</div>
<?php require_once './templates/footer.php'; ?>