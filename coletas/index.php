<?php
require_once '../config/verificar_sessao.php';
require_once '../views/templates/header.php';
?>
<div class="menu-container">
    <h1>Gestão de Coletas</h1>
    <div class="menu-grid">
        <a href="adicionar_coleta.php" class="menu-item">
            <img src="../assets/icones/add.png" alt="Adicionar Coleta">
            <span>Adicionar Coleta</span>
        </a>
        <a href="locais_coleta.php" class="menu-item">
            <img src="../assets/icones/home.png" alt="Locais de Coleta">
            <span>Locais de Coleta</span>
        </a>
        <a href="veiculos_coleta.php" class="menu-item">
            <img src="../assets/icones/edit.png" alt="Veículos">
            <span>Veículos</span>
        </a>
        <a href="relatorio_coletas.php" class="menu-item">
            <img src="../assets/icones/download.png" alt="Relatórios">
            <span>Relatórios</span>
        </a>
    </div>
</div>
<?php require_once '../views/templates/footer.php'; ?>