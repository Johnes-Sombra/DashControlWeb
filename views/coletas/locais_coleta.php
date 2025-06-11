<?php
require_once '../../config/verificar_sessao.php';
require_once '../templates/header.php';
?>
<div class="form-container">
    <h1>Cadastrar Local de Coleta</h1>
    
    <form id="localForm" action="/processar_local.php" method="POST">
        <!-- ... conteúdo do formulário mantido igual ... -->
    </form>
</div>
<?php require_once '../templates/footer.php'; ?>