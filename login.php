<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = $_POST['senha'];

    try {
        $db = new Database();
        $conn = $db->getAuthConnection(); // Alterado para usar a conexão de autenticação
        
        $stmt = $conn->prepare('SELECT id, usuario, senha, nivel_acesso FROM usuarios WHERE usuario = ? AND ativo = 1');
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['nivel_acesso'] = $user['nivel_acesso'];
            
            header('Location: index.php');
            exit;
        } else {
            header('Location: login.html?erro=1');
            exit;
        }
    } catch(PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        header('Location: login.html?erro=2');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cooperativa Coopsul</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
    <form method="post" action="">
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>