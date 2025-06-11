<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: /dashboard');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<!-- ... resto do conteúdo do login mantido igual ... -->