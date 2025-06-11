// Função para carregar a lista de usuários
function loadUsers() {
    fetch('../../admin/processar_usuario.php?acao=listar')
        .then(response => response.json())
        .then(users => {
            const usersList = document.getElementById('usersList');
            usersList.innerHTML = '';

            users.forEach(user => {
                const userDiv = document.createElement('div');
                userDiv.className = 'user-item';
                userDiv.innerHTML = `
                    <div class="user-info">
                        <h3>${user.nome}</h3>
                        <p>Usuário: ${user.usuario}</p>
                        <p>Email: ${user.email}</p>
                        <p>Nível: ${user.nivel_acesso}</p>
                    </div>
                    <div class="user-actions">
                        <button onclick="editUser(${user.id})" class="btn-secondary">Editar</button>
                        <button onclick="deleteUser(${user.id})" class="btn-danger">Excluir</button>
                    </div>
                `;
                usersList.appendChild(userDiv);
            });
        })
        .catch(error => console.error('Erro ao carregar usuários:', error));
}

// Função para mostrar o modal de adicionar usuário
function showAddUserForm() {
    document.getElementById('modalTitle').textContent = 'Adicionar Usuário';
    document.getElementById('userForm').reset();
    document.getElementById('userId').value = '';
    document.getElementById('senhaGroup').style.display = 'block';
    document.getElementById('userModal').style.display = 'block';
}

// Função para editar usuário
function editUser(userId) {
    const users = document.querySelectorAll('.user-item');
    const user = Array.from(users).find(item => {
        return item.querySelector(`button[onclick="editUser(${userId})"]`);
    });

    if (user) {
        document.getElementById('modalTitle').textContent = 'Editar Usuário';
        document.getElementById('userId').value = userId;
        document.getElementById('userUsuario').value = user.querySelector('p').textContent.replace('Usuário: ', '');
        document.getElementById('userNome').value = user.querySelector('h3').textContent;
        document.getElementById('userEmail').value = user.querySelectorAll('p')[1].textContent.replace('Email: ', '');
        document.getElementById('userNivel').value = user.querySelectorAll('p')[2].textContent.replace('Nível: ', '');
        document.getElementById('senhaGroup').style.display = 'none';
        document.getElementById('userModal').style.display = 'block';
    }
}

// Função para excluir usuário
function deleteUser(userId) {
    if (confirm('Tem certeza que deseja excluir este usuário?')) {
        const formData = new FormData();
        formData.append('acao', 'excluir');
        formData.append('id', userId);

        fetch('../../admin/processar_usuario.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Usuário excluído com sucesso!');
                loadUsers();
            } else {
                throw new Error(data.error || 'Erro ao excluir usuário');
            }
        })
        .catch(error => alert(error.message));
    }
}

// Função para fechar o modal
function closeModal() {
    document.getElementById('userModal').style.display = 'none';
}

// Event listener para o formulário
document.getElementById('userForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const userId = document.getElementById('userId').value;
    const formData = new FormData();
    formData.append('acao', userId ? 'atualizar' : 'adicionar');
    if (userId) formData.append('id', userId);
    formData.append('usuario', document.getElementById('userUsuario').value);
    formData.append('nome', document.getElementById('userNome').value);
    formData.append('email', document.getElementById('userEmail').value);
    formData.append('nivel_acesso', document.getElementById('userNivel').value);
    
    const senha = document.getElementById('userSenha').value;
    if (senha || !userId) formData.append('senha', senha);

    fetch('../../admin/processar_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal();
            loadUsers();
        } else {
            throw new Error(data.error || 'Erro ao processar usuário');
        }
    })
    .catch(error => alert(error.message));
});

// Carregar usuários ao iniciar a página
document.addEventListener('DOMContentLoaded', loadUsers);