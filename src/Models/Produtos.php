<?php
require_once __DIR__ . '/../config.php';

class Produtos
{
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $estoque;

    // Getters e Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getNome()
    {
        return $this->nome;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setPreco($preco)
    {
        // garante número (ex: "10,50" -> "10.50")
        $preco = str_replace(',', '.', $preco);
        $this->preco = (float) $preco;
    }
    public function getPreco()
    {
        return $this->preco;
    }

    public function setEstoque($estoque)
    {
        $this->estoque = (int) $estoque;
    }
    public function getEstoque()
    {
        return $this->estoque;
    }

    // CRUD
    public function salvar()
    {
        global $pdo;
        try {
            $sql = "INSERT INTO produtos (nome, descricao, preco, estoque)
                    VALUES (:nome, :descricao, :preco, :estoque)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nome', $this->nome);
            $stmt->bindValue(':descricao', $this->descricao);
            $stmt->bindValue(':preco', $this->preco);
            $stmt->bindValue(':estoque', $this->estoque);
            $stmt->execute();
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function listarTodos()
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM produtos ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar()
    {
        global $pdo;
        try {
            $sql = "UPDATE produtos
                    SET nome = :nome, descricao = :descricao, preco = :preco, estoque = :estoque
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nome', $this->nome);
            $stmt->bindValue(':descricao', $this->descricao);
            $stmt->bindValue(':preco', $this->preco);
            $stmt->bindValue(':estoque', $this->estoque);
            $stmt->bindValue(':id', $this->id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deletar($id)
    {
        global $pdo;
        try {
            $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = :id");
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>