<?php
require_once '../../config/verificar_sessao.php';
require_once '../templates/header.php';
?>
<div class="form-container">
    <h1>Adicionar Coleta</h1>
    
    <form id="coletaForm" action="/processar_coleta.php" method="POST">
        <div class="form-group">
            <label for="local-origem">Local de origem</label>
            <select id="local-origem" name="local_origem" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="AmBev">AmBev</option>
                <option value="Outro">Outro</option>
            </select>
        </div>
        <!-- ... resto do formulário mantido igual ... -->
    </form>
</div>
<?php require_once '../templates/footer.php'; ?>