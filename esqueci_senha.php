<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/logos/ktn_icon.ico">
    <link rel="stylesheet" href="./assets/css/login-style.css">
    <title>Recuperar Senha - Dash Control Web</title>
</head>
<body>
    <div class="login-container">
        <h2>Recuperar Senha</h2>
        <form id="recoveryForm">
            <div class="form-group">
                <label for="usuario">Usuário</label>
                <input type="text" id="usuario" name="usuario" placeholder="Digite seu usuário" required>
                <div id="usuarioError" class="error-message">Por favor, insira o usuário</div>
            </div>
            
            <div class="button-group">
                <button type="submit" class="login-btn">Enviar Link de Recuperação</button>
                <a href="login.php" class="back-link">Voltar para Login</a>
            </div>

            <div id="messageBox" class="message-box" style="display: none;"></div>
        </form>
    </div>

    <script>
    document.getElementById('recoveryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const usuario = document.getElementById('usuario').value;
        const messageBox = document.getElementById('messageBox');

        fetch('admin/processar_usuario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `acao=recuperar&usuario=${encodeURIComponent(usuario)}`
        })
        .then(response => response.json())
        .then(data => {
            messageBox.style.display = 'block';
            if (data.success) {
                messageBox.className = 'message-box success';
                messageBox.textContent = data.message;
                setTimeout(() => {
                    window.location.href = 'views/admin/usuarios.php';
                }, 2000);
            } else {
                messageBox.className = 'message-box error';
                messageBox.textContent = data.error || 'Erro ao processar a solicitação';
            }
        })
        .catch(error => {
            messageBox.style.display = 'block';
            messageBox.className = 'message-box error';
            messageBox.textContent = 'Erro ao processar a solicitação';
        });
    });
    </script>
</body>
</html>