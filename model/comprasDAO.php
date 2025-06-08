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

        $sql = "INSERT INTO compras (idProduto, valorEntrada, qtdParcelas, vlrParcela) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $compras->getIdProduto(),
            $compras->getValorEntrada(),
            $compras->getQntParcelas(),
            $compras->getVlrParcela()
        ]);
    }
    public function atualizarBDJuros($totalTaxas)
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
            $valorFinancimento = $valor['valor'] - $valor['valorEntrada'];
            $jurosDecimais = $totalTaxas / 100;
            $valorComJuros = $valorFinancimento * ($jurosDecimais + 1);
            $valorParcelas = $valorComJuros / $valor['qtdParcelas'];
            
            $JUROSTOTAL = $valorComJuros - $valorFinancimento;

                $stmt2->execute([
                    $valorParcelas,
                    $JUROSTOTAL,
                    $valor['id']
                ]);
        }
    }

}
