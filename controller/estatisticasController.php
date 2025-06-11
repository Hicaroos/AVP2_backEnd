<?php

require_once '../model/comprasDAO.php';


class EstatisticasController
{

    public function buscaEstatisticas()
    {
        $dao = new ComprasDAO();
        $dados = $dao->buscarCompras();
        $sum = 0;
        $sumTx = 0;
        $numJuros = 0;
        $avg = 0;
        $avgTx = 0;
        $count = count($dados);

        if ($count > 0) {
            foreach ($dados as $dado) {
                $sum += ($dado['valorEntrada'] + ($dado['valorParcela']) * $dado['qtdParcelas']);
                if ($dado['taxaJuros']) {
                    $sumTx += $dado['taxaJuros'];
                    $numJuros += 1;
                }
            }
            $avg = $sum / $count;
            if ($numJuros > 0) {
                $avgTx = $sumTx / $numJuros;
            } else {
                $avgTx = 0;
            }
        }
        $array = [
            "count" => $count,
            "sum" => round($sum, 2),
            "avg" => round($avg, 2),
            "sumTx" => round($sumTx, 2),
            "avgTx" => round($avgTx, 2),
        ];
        echo json_encode($array);
    }
}
