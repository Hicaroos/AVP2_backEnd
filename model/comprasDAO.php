<?php

require_once 'comprasModel.php';
require_once '../config/conexao.php';

class ComprasDAO{

    private $Conn;

    public function __construct(){

        $this->Conn = Conexao::getConn();
    }

    public function comprar(Compras $compras){

        $productid = 

        $sql = "INSERT INTO compras (idProduto, valorEntrada, qtdParcelas) VALUES (?, ?, ?)";
        $stmt = $this->Conn->prepare($sql);
        $stmt->execute([
            $compras->getIdProduto(),
            $compras->getValorEntrada(),
            $compras->getQntParcelas()
        ]);
    }

}