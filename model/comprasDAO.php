<?php

require_once 'comprasModel.php';
require_once '../config/conexao.php';

class ComprasDAO
{

    private $conn;

    public function __construct()
    {

        $this->conn = Conexao::getConn();
    }

    public function comprar(Compras $compras)
    {

        $sql = "INSERT INTO compras (idProduto, valorEntrada, qtdParcelas, vlrParcela, jurosAplicados) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $compras->getIdProduto(),
            $compras->getValorEntrada(),
            $compras->getQtdParcelas(),
            $compras->getVlrParcela(),
            $compras->getJurosAplicado()
        ]);
    }
    public function atualizarBDCompras($totalTaxas)
    {
        $select = "SELECT c.id, c.valorEntrada, c.qtdParcelas, p.valor
                FROM compras c
                JOIN produtos p ON c.idProduto = p.id WHERE c.qtdParcelas > 6";

        $stmt = $this->conn->prepare($select);
        $stmt->execute();

        $valoresBD = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $update = 'UPDATE compras SET vlrParcela = ?, jurosAplicados = ? WHERE id = ?';

        foreach ($valoresBD as $valor) {

            $stmt2 = $this->conn->prepare($update);
            
            $valorFinanciamento = $valor['valor'] - $valor['valorEntrada'];
            $jurosSelic = $totalTaxas / 100;
            $valorComJuros = $valorFinanciamento * ($jurosSelic + 1);
            $valorParcelas = $valorComJuros / $valor['qtdParcelas'];
            $JUROSTOTAL = $valorComJuros - $valorFinanciamento;

                $stmt2->execute([
                    $valorParcelas,
                    $JUROSTOTAL,
                    $valor['id']
                ]);
        }
    }
    public function buscarValorProduto($idProduto){
        $sql = "SELECT valor FROM produtos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idProduto]);
        $valor = $stmt->fetch(PDO::FETCH_ASSOC);
        return $valor['valor'];
    }
}
