<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Erro - Dash Control Web</title>
    <link rel="stylesheet" href="/assets/css/main-style.css">
</head>
<body>
    <div class="error-container">
        <h1>Oops!</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="/" class="btn-voltar">Voltar à página inicial</a>
    </div>
</body>
</html>