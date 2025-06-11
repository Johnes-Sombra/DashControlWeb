<?php
require_once '../../config/verificar_sessao.php';
require_once '../../views/templates/header.php';
?>
<div class="success-container">
    <img src="../../assets/images/sucesso.png" alt="Sucesso">
    <h2>Coleta Registrada com Sucesso!</h2>
    <div class="button-group">
        <a href="../index.php" class="btn-primary">Voltar para Coletas</a>
        <a href="index.php" class="btn-secondary">Nova Coleta</a>
    </div>
</div>
<?php require_once '../../views/templates/footer.php'; ?>