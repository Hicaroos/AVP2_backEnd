<?php

class Compras
{
    private $id;
    private $idProduto;
    private $valorEntrada;
    private $qntParcelas;

    public function __construct($idProduto, $valorEntrada, $qntParcelas)
    {
        $this->idProduto = $idProduto;
        $this->valorEntrada = $valorEntrada;
        $this->qntParcelas = $qntParcelas;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdProduto()
    {
        return $this->idProduto;
    }

    public function getValorEntrada()
    {
        return $this->valorEntrada;
    }

    public function getQntParcelas()
    {
        return $this->qntParcelas;
    }
    public function setQntParcelas($qntParcelas)
    {
        $this->qntParcelas = $qntParcelas;
    }
    public function setValorEntrada($valorEntrada)
    {
        $this->valorEntrada = $valorEntrada;
    }
    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
}
