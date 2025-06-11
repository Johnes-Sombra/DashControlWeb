<?php
require_once '../../config/verificar_sessao.php';
require_once '../templates/header.php';
?>
<div class="form-container">
    <h1>Cadastrar Veículo</h1>
    
    <form id="veiculoForm" action="/processar_veiculo.php" method="POST">
        <!-- ... conteúdo do formulário mantido igual ... -->
    </form>
</div>
<?php require_once '../templates/footer.php'; ?>