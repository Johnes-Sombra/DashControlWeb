<?php
// Comentando a verificação de sessão durante o desenvolvimento
// require_once '../../config/verificar_sessao.php';
require_once '../templates/header.php';
?>
<link rel="stylesheet" href="../../assets/css/main-style.css">
<div class="menu-container">
    <h1>Gerenciamento de Usuários</h1>
    
    <div class="actions">
        <button onclick="showAddUserForm()" class="btn-primary">Adicionar Usuário</button>
    </div>

    <div id="usersList" class="users-list">
        <!-- Lista de usuários será carregada aqui via JavaScript -->
    </div>

    <!-- Modal para adicionar/editar usuário -->
    <div id="userModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2 id="modalTitle">Adicionar Usuário</h2>
            <form id="userForm">
                <input type="hidden" id="userId">
                <div class="form-group">
                    <label for="userUsuario">Usuário:</label>
                    <input type="text" id="userUsuario" required>
                </div>
                <div class="form-group">
                    <label for="userNome">Nome Completo:</label>
                    <input type="text" id="userNome">
                </div>
                <div class="form-group">
                    <label for="userEmail">Email:</label>
                    <input type="email" id="userEmail">
                </div>
                <div class="form-group">
                    <label for="userNivel">Nível de Acesso:</label>
                    <select id="userNivel">
                        <option value="usuario">Usuário</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="form-group" id="senhaGroup">
                    <label for="userSenha">Senha:</label>
                    <input type="password" id="userSenha">
                </div>
                <div class="button-group">
                    <button type="submit" class="btn-primary">Salvar</button>
                    <button type="button" onclick="closeModal()" class="btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../../assets/js/usuarios.js"></script>
<?php require_once '../templates/footer.php'; ?>