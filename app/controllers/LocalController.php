<?php
class LocalController {
    private $db;
    private $local;

    public function __construct() {
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../models/Local.php';
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->local = new Local($this->db);
    }

    public function index() {
        $locais = $this->local->listar();
        require_once __DIR__ . '/../views/locais/index.php';
    }

    public function criar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->local->nome = htmlspecialchars(strip_tags($_POST['nome']));
            $this->local->endereco = htmlspecialchars(strip_tags($_POST['endereco']));
            $this->local->cidade = htmlspecialchars(strip_tags($_POST['cidade']));
            $this->local->estado = htmlspecialchars(strip_tags($_POST['estado']));
            $this->local->cep = htmlspecialchars(strip_tags($_POST['cep']));
            $this->local->contato = htmlspecialchars(strip_tags($_POST['contato']));
            $this->local->telefone = htmlspecialchars(strip_tags($_POST['telefone']));

            if ($this->local->criar()) {
                header('Location: /locais');
                exit;
            } else {
                echo "Erro ao criar local";
            }
        }
        require_once __DIR__ . '/../views/locais/criar.php';
    }

    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->local->id = $id;
            $this->local->nome = htmlspecialchars(strip_tags($_POST['nome']));
            $this->local->endereco = htmlspecialchars(strip_tags($_POST['endereco']));
            $this->local->cidade = htmlspecialchars(strip_tags($_POST['cidade']));
            $this->local->estado = htmlspecialchars(strip_tags($_POST['estado']));
            $this->local->cep = htmlspecialchars(strip_tags($_POST['cep']));
            $this->local->contato = htmlspecialchars(strip_tags($_POST['contato']));
            $this->local->telefone = htmlspecialchars(strip_tags($_POST['telefone']));

            if ($this->local->atualizar()) {
                header('Location: /locais');
                exit;
            } else {
                echo "Erro ao atualizar local";
            }
        }
        require_once __DIR__ . '/../views/locais/editar.php';
    }

    public function deletar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->local->id = $id;
            if ($this->local->deletar()) {
                header('Location: /locais');
                exit;
            } else {
                echo "Erro ao deletar local";
            }
        }
    }
}