<div class="form-container">
    <form id="formColeta" method="POST" action="/coletas/salvar">
        <section class="form-section">
            <h2>Dados da Coleta</h2>
            
            <div class="form-group">
                <label for="data_coleta">Data da Coleta:</label>
                <input type="datetime-local" id="data_coleta" name="data_coleta" value="<?php echo date('Y-m-d\\TH:i'); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="local_coleta">Local da Coleta:</label>
                <select id="local_coleta" name="local_coleta" required>
                    <option value="Não informado">Não informado</option>
                    <?php foreach($locais as $local): ?>
                        <option value="<?php echo $local['id']; ?>"><?php echo $local['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="veiculo">Veículo utilizado:</label>
                <select id="veiculo" name="veiculo" required>
                    <option value="Não informado">Não informado</option>
                    <?php foreach($veiculos as $veiculo): ?>
                        <option value="<?php echo $veiculo['id']; ?>"><?php echo $veiculo['placa']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </section>

        <section class="form-section">
            <h2>Materiais Coletados</h2>
            
            <div class="form-group">
                <label for="papel">Papel:</label>
                <input type="number" id="papel" name="papel" step="0.1" min="0">
            </div>

            <div class="form-group">
                <label for="papelao">Papelão:</label>
                <input type="number" id="papelao" name="papelao" step="0.1" min="0">
            </div>

            <div class="form-group">
                <label for="plastico">Plástico:</label>
                <input type="number" id="plastico" name="plastico" step="0.1" min="0">
            </div>

            <div class="form-group">
                <label for="vidro">Vidro:</label>
                <input type="number" id="vidro" name="vidro" step="0.1" min="0">
            </div>

            <div class="form-group">
                <label for="metal">Metal:</label>
                <input type="number" id="metal" name="metal" step="0.1" min="0">
            </div>

            <div class="form-group">
                <label for="aluminio">Alumínio:</label>
                <input type="number" id="aluminio" name="aluminio" step="0.1" min="0">
            </div>

            <div class="form-group">
                <label for="ferro">Ferro:</label>
                <input type="number" id="ferro" name="ferro" step="0.1" min="0">
            </div>

            <div class="form-group">
                <label for="eletronicos">Eletrônicos:</label>
                <input type="number" id="eletronicos" name="eletronicos" step="0.1" min="0">
            </div>

            <div class="form-group">
                <label for="madeira">Madeira:</label>
                <input type="number" id="madeira" name="madeira" step="0.1" min="0">
            </div>
        </section>

        <div class="form-actions">
            <button type="reset" class="btn-limpar">Limpar</button>
            <button type="submit" class="btn-salvar">Salvar</button>
        </div>
    </form>
</div>

<script>
document.getElementById('formColeta').onsubmit = function(e) {
    e.preventDefault();
    
    const materiais = ['papel', 'papelao', 'plastico', 'vidro', 'metal', 'aluminio', 'ferro', 'eletronicos', 'madeira'];
    let temMaterial = false;

    for (const material of materiais) {
        const valor = parseFloat(document.getElementById(material).value) || 0;
        if (valor > 1.0) {
            temMaterial = true;
            break;
        }
    }

    if (!temMaterial) {
        alert('É necessário informar ao menos um material com valor superior a 1.0');
        return false;
    }

    this.submit();
};
</script>