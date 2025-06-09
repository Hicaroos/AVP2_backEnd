<?php

class Compras
{
    private $id;
    private $idProduto;
    private $valorEntrada;
    private $qntParcelas;
    private $vlrParcela;
    private $jurosAplicado;

    public function __construct($idProduto, $valorEntrada, $qntParcelas, $vlrParcela)
    {
        $this->idProduto = $idProduto;
        $this->valorEntrada = $valorEntrada;
        $this->qntParcelas = $qntParcelas;
        $this->vlrParcela = $vlrParcela;
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

    public function getQtdParcelas()
    {
        return $this->qntParcelas;
    }
    public function getVlrParcela()
    {
        return $this->vlrParcela;
    }
    public function getJurosAplicado()
    {
        return $this->jurosAplicado;
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
    public function setVlrParcela($vlrParcela)
    {
        $this->vlrParcela = $vlrParcela;
    }
    public function setJurosAplicado($jurosAplicado)
    {
        $this->jurosAplicado = $jurosAplicado;
    }
}
