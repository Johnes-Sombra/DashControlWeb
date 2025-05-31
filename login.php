<?php
session_start();

// Definições de usuário e senha
$usuario_valido = 'coopsul';
$senha_valida = '123456';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Verifica as credenciais
    if ($usuario === $usuario_valido && $senha === $senha_valida) {
        $_SESSION['logado'] = true;
        header('Location: index.html'); // Redireciona para a página principal
        exit;
    } else {
        $erro = 'Usuário ou senha inválidos!';
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