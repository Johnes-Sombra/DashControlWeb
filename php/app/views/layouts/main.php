<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashControl</title>
    <link rel="stylesheet" href="/assets/css/estilo_principal.css">
</head>
<body>
    <nav class="main-nav">
        <div class="logo">
            <img src="/assets/logos/ktn_png.png" alt="Logo DashControl">
        </div>
        <ul class="nav-links">
            <li><a href="/coletas">Página Coletas</a></li>
            <li><a href="/cooperados" class="disabled">Página Cooperados (Em desenvolvimento)</a></li>
            <li><a href="/empresas" class="disabled">Página Empresas (Em desenvolvimento)</a></li>
        </ul>
    </nav>
    
    <main class="content">
        <?php echo $content; ?>
    </main>
</body>
</html>