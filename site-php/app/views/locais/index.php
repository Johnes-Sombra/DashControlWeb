<div class="content-container">
    <div class="header">
        <h1>Locais de Coleta</h1>
        <a href="/locais/criar" class="btn btn-primary">Adicionar Local</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Contato</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($local = $locais->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($local['nome']); ?></td>
                <td><?php echo htmlspecialchars($local['endereco']); ?></td>
                <td><?php echo htmlspecialchars($local['cidade']); ?></td>
                <td><?php echo htmlspecialchars($local['estado']); ?></td>
                <td><?php echo htmlspecialchars($local['contato']); ?></td>
                <td><?php echo htmlspecialchars($local['telefone']); ?></td>
                <td>
                    <div class="btn-group">
                        <a href="/locais/editar/<?php echo $local['id']; ?>" class="btn btn-edit">Editar</a>
                        <button onclick="confirmarDelecao(<?php echo $local['id']; ?>)" class="btn btn-delete">Excluir</button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function confirmarDelecao(id) {
    if (confirm('Tem certeza que deseja excluir este local?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/locais/deletar/' + id;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>