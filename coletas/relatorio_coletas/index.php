<?php
require_once '../../config/verificar_sessao.php';
require_once '../../views/templates/header.php';
?>
<style>
    .table-container {
        margin: 20px;
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #1B5E20;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

<div class="form-container">
    <h1>Relatório de Coletas</h1>
    
    <div class="form-actions">
        <button type="button" class="btn-back" onclick="window.location.href='../index.php'">Voltar</button>
        <button type="button" class="btn-submit" id="btnFiltrar">Filtrar</button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Local</th>
                    <th>Papel/Papelão</th>
                    <th>Plástico</th>
                    <th>Vidro</th>
                    <th>Metal</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="tabela-coletas">
                <?php
                // Aqui você pode adicionar a lógica para buscar e exibir os dados do banco
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../../views/templates/footer.php'; ?>