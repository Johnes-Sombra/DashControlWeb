<?php
class Coleta {
    private $conn;
    private $table_name = "coletas";

    public $id;
    public $data_coleta;
    public $local_id;
    public $veiculo_id;
    public $papel;
    public $papelao;
    public $plastico;
    public $vidro;
    public $metal;
    public $aluminio;
    public $ferro;
    public $eletronicos;
    public $madeira;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . "
                (data_coleta, local_id, veiculo_id, papel, papelao, plastico, 
                 vidro, metal, aluminio, ferro, eletronicos, madeira)
                VALUES
                (:data_coleta, :local_id, :veiculo_id, :papel, :papelao, :plastico,
                 :vidro, :metal, :aluminio, :ferro, :eletronicos, :madeira)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":data_coleta", $this->data_coleta);
        $stmt->bindParam(":local_id", $this->local_id);
        $stmt->bindParam(":veiculo_id", $this->veiculo_id);
        $stmt->bindParam(":papel", $this->papel);
        $stmt->bindParam(":papelao", $this->papelao);
        $stmt->bindParam(":plastico", $this->plastico);
        $stmt->bindParam(":vidro", $this->vidro);
        $stmt->bindParam(":metal", $this->metal);
        $stmt->bindParam(":aluminio", $this->aluminio);
        $stmt->bindParam(":ferro", $this->ferro);
        $stmt->bindParam(":eletronicos", $this->eletronicos);
        $stmt->bindParam(":madeira", $this->madeira);

        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT c.*, l.nome as local_nome, v.placa as veiculo_placa 
                 FROM " . $this->table_name . " c
                 LEFT JOIN locais l ON c.local_id = l.id
                 LEFT JOIN veiculos v ON c.veiculo_id = v.id
                 ORDER BY c.data_coleta DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}