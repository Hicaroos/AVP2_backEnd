<?php

require_once 'produtosModel.php';
require_once '../config/Conexao.php';

class ProdutosDAO
{

    private $Conn;

    public function __construct()
    {
        $this->Conn = Conexao::getConn();
    }
    public function cadastrarProduto(Produtos $produto)
    {
        $sql = "INSERT INTO produtos (nome, tipo, valor) VALUES (?, ?, ?)";
        $stmt = $this->Conn->prepare($sql);
        $stmt->execute([
            $produto->getNome(),
            $produto->getTipo(),
            $produto->getValor()
        ]);
    }
    public function validarIdProduto($idProduto)
    {
        $stmt = $this->Conn->prepare('SELECT id FROM produtos WHERE id = ?');
        $stmt->execute([$idProduto]);
        $valid = $stmt->fetch(PDO::FETCH_ASSOC);
        return $valid;
    }
    public function validarNomeProduto($nomeProduto)
    {
        $stmt = $this->Conn->prepare('SELECT nome FROM produtos WHERE nome = ?');
        $stmt->execute([$nomeProduto]);
        $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->rowCount() > 0;
    }
}
