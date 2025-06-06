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
}
