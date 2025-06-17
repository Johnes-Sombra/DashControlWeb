<?php
class ColetaController {
    private $db;
    private $coleta;

    public function __construct() {
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../models/Coleta.php';
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->coleta = new Coleta($this->db);
    }

    public function index() {
        $coletas = $this->coleta->listar();
        require_once __DIR__ . '/../views/coletas/relatorio.php';
    }

    public function adicionar() {
        require_once __DIR__ . '/../views/coletas/adicionar.php';
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->coleta->data_coleta = $_POST['data_coleta'];
            $this->coleta->local_id = $_POST['local_coleta'];
            $this->coleta->veiculo_id = $_POST['veiculo'];
            $this->coleta->papel = $_POST['papel'] ?? 0;
            $this->coleta->papelao = $_POST['papelao'] ?? 0;
            $this->coleta->plastico = $_POST['plastico'] ?? 0;
            $this->coleta->vidro = $_POST['vidro'] ?? 0;
            $this->coleta->metal = $_POST['metal'] ?? 0;
            $this->coleta->aluminio = $_POST['aluminio'] ?? 0;
            $this->coleta->ferro = $_POST['ferro'] ?? 0;
            $this->coleta->eletronicos = $_POST['eletronicos'] ?? 0;
            $this->coleta->madeira = $_POST['madeira'] ?? 0;

            if ($this->coleta->criar()) {
                header('Location: /coletas');
            } else {
                echo "Erro ao salvar coleta";
            }
        }
    }
}