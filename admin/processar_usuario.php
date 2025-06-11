<?php
session_start();
require_once '../config/database.php';

// Verificar se é administrador
if (!isset($_SESSION['nivel_acesso']) || $_SESSION['nivel_acesso'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit('Acesso negado');
}

$db = new Database();
$conn = $db->getConnection();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        // Criar novo usuário
        $data = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $conn->prepare('INSERT INTO usuarios (usuario, senha, nome_completo, email, nivel_acesso) VALUES (?, ?, ?, ?, ?)');
        $senha_hash = password_hash($data['senha'], PASSWORD_DEFAULT);
        
        try {
            $stmt->execute([
                $data['usuario'],
                $senha_hash,
                $data['nome'] ?? null,
                $data['email'] ?? null,
                $data['nivel'] ?? 'usuario'
            ]);
            echo json_encode(['success' => true, 'message' => 'Usuário criado com sucesso']);
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Erro ao criar usuário']);
        }
        break;

    case 'GET':
        // Listar usuários
        $stmt = $conn->query('SELECT id, usuario, nome_completo, email, nivel_acesso, ativo FROM usuarios');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'PUT':
        // Atualizar usuário
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare('UPDATE usuarios SET nome_completo = ?, email = ?, nivel_acesso = ?, ativo = ? WHERE id = ?');
        
        try {
            $stmt->execute([
                $data['nome'],
                $data['email'],
                $data['nivel'],
                $data['ativo'],
                $data['id']
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(['success' => false]);
        }
        break;

    case 'DELETE':
        // Desativar usuário (soft delete)
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $stmt = $conn->prepare('UPDATE usuarios SET ativo = 0 WHERE id = ?');
        
        try {
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(['success' => false]);
        }
        break;
}
?>