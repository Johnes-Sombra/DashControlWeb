<?php
class Local {
    private $conn;
    private $table_name = "locais";

    public $id;
    public $nome;
    public $endereco;
    public $cidade;
    public $estado;
    public $cep;
    public $contato;
    public $telefone;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . "
                (nome, endereco, cidade, estado, cep, contato, telefone)
                VALUES
                (:nome, :endereco, :cidade, :estado, :cep, :contato, :telefone)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":endereco", $this->endereco);
        $stmt->bindParam(":cidade", $this->cidade);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":cep", $this->cep);
        $stmt->bindParam(":contato", $this->contato);
        $stmt->bindParam(":telefone", $this->telefone);

        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . "
                SET nome = :nome,
                    endereco = :endereco,
                    cidade = :cidade,
                    estado = :estado,
                    cep = :cep,
                    contato = :contato,
                    telefone = :telefone
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":endereco", $this->endereco);
        $stmt->bindParam(":cidade", $this->cidade);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":cep", $this->cep);
        $stmt->bindParam(":contato", $this->contato);
        $stmt->bindParam(":telefone", $this->telefone);

        return $stmt->execute();
    }

    public function deletar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}