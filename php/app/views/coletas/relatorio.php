<div class="report-container">
    <h1>Relatório de Coletas</h1>

    <div class="actions">
        <a href="/coletas/adicionar" class="btn btn-primary">Nova Coleta</a>
        <button id="btnFiltrar" class="btn btn-secondary">Filtrar</button>
    </div>

    <div class="filter-panel" style="display: none;">
        <form id="formFiltro">
            <div class="form-group">
                <label>Período:</label>
                <input type="date" name="data_inicio">
                <input type="date" name="data_fim">
            </div>
            <div class="form-group">
                <label>Material:</label>
                <select name="material">
                    <option value="">Todos</option>
                    <option value="papel">Papel</option>
                    <option value="papelao">Papelão</option>
                    <option value="plastico">Plástico</option>
                    <option value="vidro">Vidro</option>
                    <option value="metal">Metal</option>
                    <option value="aluminio">Alumínio</option>
                    <option value="ferro">Ferro</option>
                    <option value="eletronicos">Eletrônicos</option>
                    <option value="madeira">Madeira</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Local</th>
                <th>Veículo</th>
                <th>Materiais</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $coletas->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo date('d/m/Y H:i', strtotime($row['data_coleta'])); ?></td>
                <td><?php echo htmlspecialchars($row['local_nome']); ?></td>
                <td><?php echo htmlspecialchars($row['veiculo_placa']); ?></td>
                <td>
                    <?php
                    $materiais = [];
                    if ($row['papel'] > 0) $materiais[] = "Papel: {$row['papel']}kg";
                    if ($row['papelao'] > 0) $materiais[] = "Papelão: {$row['papelao']}kg";
                    if ($row['plastico'] > 0) $materiais[] = "Plástico: {$row['plastico']}kg";
                    if ($row['vidro'] > 0) $materiais[] = "Vidro: {$row['vidro']}kg";
                    if ($row['metal'] > 0) $materiais[] = "Metal: {$row['metal']}kg";
                    if ($row['aluminio'] > 0) $materiais[] = "Alumínio: {$row['aluminio']}kg";
                    if ($row['ferro'] > 0) $materiais[] = "Ferro: {$row['ferro']}kg";
                    if ($row['eletronicos'] > 0) $materiais[] = "Eletrônicos: {$row['eletronicos']}kg";
                    if ($row['madeira'] > 0) $materiais[] = "Madeira: {$row['madeira']}kg";
                    echo implode(", ", $materiais);
                    ?>
                </td>
                <td>
                    <button class="btn btn-edit" data-id="<?php echo $row['id']; ?>">Editar</button>
                    <button class="btn btn-delete" data-id="<?php echo $row['id']; ?>">Excluir</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('btnFiltrar').onclick = function() {
    const filterPanel = document.querySelector('.filter-panel');
    filterPanel.style.display = filterPanel.style.display === 'none' ? 'block' : 'none';
};
</script>