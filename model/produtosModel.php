<?php

class Produtos
{
    private $id;
    private $nome;
    private $tipo;
    private $valor;

    public function __construct($nome, $tipo, $valor)
    {
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->valor = $valor;
    }

    public function getId(){return $this->id;}
    public function getNome(){return $this->nome;}
    public function getTipo(){return $this->tipo;}
    public function getValor(){return $this->valor;}
    public function setId($id){$this->id = $id;}
    public function setNome($nome){$this->nome = $nome;}
    public function setValor($valor){$this->valor = $valor;}
    public function setTipo($tipo){$this->tipo = $tipo;}
}
