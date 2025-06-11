<?php

require_once '../model/comprasDAO.php';
require_once '../model/jurosDAO.php';
class JurosController
{
    public function atualizarJuros()
    {
        $json = file_get_contents('php://input');
        $dados = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            return;
        }
        if (!isset($dados['dataInicio']) || !isset($dados['dataFinal'])) {
            http_response_code(422);
            return;
        }

        try {
            $dataInicio = new DateTime($dados['dataInicio']);
            $dataFinal = new DateTime($dados['dataFinal']);
            $hoje = new DateTime();
            $limiteInicio = new DateTime('2010-01-01');

            if ($dataFinal < $dataInicio || $dataFinal > $hoje || $dataInicio < $limiteInicio) {
                http_response_code(400);
                return;
            }
            $dataInicioFormat = $dataInicio->format('d/m/Y');
            $dataFinalFormat = $dataFinal->format('d/m/Y');

            $url = "https://api.bcb.gov.br/dados/serie/bcdata.sgs.11/dados?formato=json&dataInicial={$dataInicioFormat}&dataFinal={$dataFinalFormat}";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $valoresApi = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if (isset($valoresApi['erro']) || isset($valoresApi['error'])) {
                http_response_code(400);
                return;
            }
            $valorTotal = 0;

            foreach ($valoresApi as $valor) {
                $valorTotal += $valor['valor'];
            }

            $dao = new ComprasDAO();
            $dao->atualizarBDCompras($valorTotal);

            $jurosModel = new Juros($dados['dataInicio'], $dados['dataFinal'], $valorTotal);
            $jurosDao = new JurosDAO();
            $jurosDao->salvarJuros($jurosModel);

            http_response_code(200);
            echo json_encode(["sucesso" => "A taxa de juros foi atualizada", "novaTaxaDeJuros" => $valorTotal]);
        } catch (Exception $e) {
            http_response_code(400);
        }
    }
}
