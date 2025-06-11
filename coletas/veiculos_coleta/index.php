<?php
require_once '../../config/verificar_sessao.php';
require_once '../../views/templates/header.php';
?>
<div class="form-container">
    <h1>Cadastrar Veículo</h1>
    
    <form id="veiculoForm" action="processar_veiculo.php" method="POST">
        <div class="form-group">
            <label for="nome-veiculo">Nome do Veículo*</label>
            <input type="text" id="nome-veiculo" name="nome_veiculo" required>
        </div>
        
        <div class="form-group">
            <label for="proprietario">Nome do Proprietário</label>
            <input type="text" id="proprietario" name="proprietario">
        </div>
        
        <div class="form-group">
            <label for="placa">Placa do Veículo</label>
            <input type="text" id="placa" name="placa">
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
    document.getElementById('veiculoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Implementar lógica de salvamento via AJAX
    });

    document.getElementById('btnLimpar').addEventListener('click', function() {
        document.getElementById('veiculoForm').reset();
    });
</script>
<?php require_once '../../views/templates/footer.php'; ?>