<?php
require_once '../../config/verificar_sessao.php';
require_once '../../views/templates/header.php';
?>
<div class="form-container">
    <h1>Cadastrar Local de Coleta</h1>
    
    <form id="localForm" action="processar_local.php" method="POST">
        <div class="form-group">
            <label for="nome-local">Nome do Local*</label>
            <input type="text" id="nome-local" name="nome_local" required>
        </div>
        
        <div class="form-group">
            <label for="representante">Nome do Representante</label>
            <input type="text" id="representante" name="representante">
        </div>
        
        <div class="form-group">
            <label for="contato">Contato</label>
            <input type="tel" id="contato" name="contato">
        </div>
        
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email">
        </div>
        
        <div class="form-actions">
            <button type="button" class="btn-back" onclick="window.location.href='../index.php'">Voltar</button>
            <button type="button" class="btn-cancel" id="btnLimpar">Limpar</button>
            <button type="submit" class="btn-submit">Salvar</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('localForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Implementar lógica de salvamento via AJAX
    });

    document.getElementById('btnLimpar').addEventListener('click', function() {
        document.getElementById('localForm').reset();
    });
</script>
<?php require_once '../../views/templates/footer.php'; ?>