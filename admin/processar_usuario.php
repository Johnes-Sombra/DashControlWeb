<?php
header('Content-Type: application/json');

require_once '../config/config.php';
require_once '../config/database.php';
// Comentando a verificação de sessão durante o desenvolvimento
// require_once '../config/verificar_sessao.php';

// Removendo a verificação de permissão de administrador
// if (!isset($_SESSION['nivel_acesso']) || $_SESSION['nivel_acesso'] !== 'admin') {
//     http_response_code(403);
//     echo json_encode(['error' => 'Acesso negado']);
//     exit;
// }

$db = new Database();
$conn = $db->getAuthConnection();

// Função para listar usuários
function listarUsuarios($conn) {
    // Removendo a restrição de não listar administradores
    $stmt = $conn->prepare("SELECT id, usuario, nome, email, nivel_acesso FROM usuarios");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para adicionar usuário
function adicionarUsuario($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, nome, email, senha, nivel_acesso) VALUES (?, ?, ?, ?, ?)");
    $senha_hash = password_hash($data['senha'], PASSWORD_DEFAULT);
    return $stmt->execute([$data['usuario'], $data['nome'], $data['email'], $senha_hash, $data['nivel_acesso']]);
}

// Função para atualizar usuário
function atualizarUsuario($conn, $data) {
    if (!empty($data['senha'])) {
        $stmt = $conn->prepare("UPDATE usuarios SET usuario = ?, nome = ?, email = ?, senha = ?, nivel_acesso = ? WHERE id = ?");
        $senha_hash = password_hash($data['senha'], PASSWORD_DEFAULT);
        return $stmt->execute([$data['usuario'], $data['nome'], $data['email'], $senha_hash, $data['nivel_acesso'], $data['id']]);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET usuario = ?, nome = ?, email = ?, nivel_acesso = ? WHERE id = ?");
        return $stmt->execute([$data['usuario'], $data['nome'], $data['email'], $data['nivel_acesso'], $data['id']]);
    }
}

// Função para excluir usuário
function excluirUsuario($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ? AND nivel_acesso != 'admin'");
    return $stmt->execute([$id]);
}

try {
    $acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
    $response = [];

    switch ($acao) {
        case 'listar':
            $response = listarUsuarios($conn);
            break;

        case 'adicionar':
            if (adicionarUsuario($conn, $_POST)) {
                $response = ['success' => true, 'message' => 'Usuário adicionado com sucesso'];
            } else {
                throw new Exception('Erro ao adicionar usuário');
            }
            break;

        case 'atualizar':
            if (atualizarUsuario($conn, $_POST)) {
                $response = ['success' => true, 'message' => 'Usuário atualizado com sucesso'];
            } else {
                throw new Exception('Erro ao atualizar usuário');
            }
            break;

        case 'excluir':
            $id = $_POST['id'] ?? 0;
            if (excluirUsuario($conn, $id)) {
                $response = ['success' => true, 'message' => 'Usuário excluído com sucesso'];
            } else {
                throw new Exception('Erro ao excluir usuário');
            }
            break;

        default:
            throw new Exception('Ação inválida');
    }

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}