<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = $_POST['senha'];

    try {
        $db = new Database();
        $conn = $db->getAuthConnection();
        
        // Verificar tentativas de login
        if (!$db->checkLoginAttempts($usuario)) {
            $db->logAccess($usuario, 'login', 'bloqueado');
            header('Location: login.html?erro=3'); // Usuário bloqueado
            exit;
        }

        $stmt = $conn->prepare('SELECT id, usuario, senha, nivel_acesso FROM usuarios WHERE usuario = ? AND ativo = 1');
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            // Login bem-sucedido
            $db->recordLoginAttempt($usuario, true);
            $db->logAccess($usuario, 'login', 'sucesso');
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['nivel_acesso'] = $user['nivel_acesso'];
            
            header('Location: index.php');
            exit;
        } else {
            // Login falhou
            $db->recordLoginAttempt($usuario, false);
            $db->logAccess($usuario, 'login', 'falha');
            
            header('Location: login.html?erro=1');
            exit;
        }
    } catch(PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        $db->logAccess($usuario, 'login', 'erro_sistema');
        header('Location: login.html?erro=2');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/logos/ktn_icon.ico">
    <link rel="stylesheet" href="./assets/css/login-style.css">
    <title>Dash Control Web | Login</title>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm" action="login.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuário</label>
                <input type="text" id="usuario" name="usuario" placeholder="Digite aqui seu usuário" required>
                <div id="usuarioError" class="error-message">Por favor, insira o usuário</div>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite aqui sua senha" required>
                <div id="senhaError" class="error-message">Por favor, insira a senha</div>
            </div>
            
            <div class="button-group">
                <button type="submit" class="login-btn">Login</button>
                <a href="esqueci_senha.html" class="forgot-password">Esqueci minha senha</a>
            </div>

            <?php
            if(isset($_GET['erro'])) {
                $mensagem = '';
                switch($_GET['erro']) {
                    case '1':
                        $mensagem = 'Usuário ou senha incorretos';
                        break;
                    case '2':
                        $mensagem = 'Erro no sistema. Tente novamente mais tarde';
                        break;
                    case '3':
                        $mensagem = 'Conta temporariamente bloqueada. Tente novamente mais tarde';
                        break;
                    case '4':
                        $mensagem = 'Sessão expirada. Por favor, faça login novamente';
                        break;
                    default:
                        $mensagem = 'Erro desconhecido';
                }
                echo '<div class="error-message" style="display: block;">' . htmlspecialchars($mensagem) . '</div>';
            }
            ?>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const usuario = document.getElementById('usuario').value.trim();
            const senha = document.getElementById('senha').value.trim();
            
            if (!usuario || !senha) {
                e.preventDefault();
                if (!usuario) document.getElementById('usuarioError').style.display = 'block';
                if (!senha) document.getElementById('senhaError').style.display = 'block';
            }
        });
    </script>
</body>
</html>