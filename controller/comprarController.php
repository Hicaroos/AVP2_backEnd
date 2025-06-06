<?php

require_once '../model/comprasDAO.php';
require_once '../model/comprasModel.php';

class ComprarController
{

    public function store()
    {

        $json = file_get_contents('php://input');
        $dados = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            return;
        }

        if (!isset($dados['idProduto']) || !isset($dados['valorEntrada']) || !isset($dados['qtdParcelas'])) {
            http_response_code(422);
            return;
        }
        try {
            $compra = new Compras($dados['idProduto'], $dados['valorEntrada'], $dados['qtdParcelas']);
            $dao = new ComprasDAO();
            $dao->comprar($compra);
            http_response_code(201);
        } catch (Exception $e) {
            http_response_code(405);
        }
    }
}
