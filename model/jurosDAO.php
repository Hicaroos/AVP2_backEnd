<?php

require_once 'JurosModel.php';
require_once '../config/conexao.php';

class JurosDAO{

    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConn();        
    }

     public function salvarJuros(Juros $juros){
        $consulta = $this->conn->prepare('SELECT id FROM juros WHERE id = 1');
        $consulta->execute();

        if ($consulta->fetch(PDO::FETCH_ASSOC)) {
            $stmt = $this->conn->prepare('UPDATE juros SET dataInicio = ?, dataFinal = ?, juros = ? WHERE id = 1');
            $stmt->execute([
                $juros->getDataInicial(),
                $juros->getDataFinal(),
                $juros->getJuros()
            ]);
        } else {
            $stmt = $this->conn->prepare('INSERT INTO juros (id, dataInicio, dataFinal, juros) VALUES (1, ?, ?, ?)');
            $stmt->execute([
                $juros->getDataInicial(),
                $juros->getDataFinal(),
                $juros->getJuros()
            ]);
        }
    }
    
    public function mostrarJuros(){

    $stmt = $this->conn->prepare('SELECT juros from juros');
    $stmt->execute();
    $juros = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $juros['juros'];
    }
}