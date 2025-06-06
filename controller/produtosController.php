<?php

require_once '../model/ProdutosDAO.php';

class ProdutosController
{

    public function criarProduto()
    {
        $json = file_get_contents('php://input');
        $dados = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            return;
        }

        if (!isset($dados['nome']) || !isset($dados['valor']) || $dados['valor'] < 0) {
            http_response_code(422);
            return;
        }
        try {
            $produto = new Produtos($dados['nome'], $dados['tipo'], $dados['valor']);
            $dao = new ProdutosDAO();
            $dao->cadastrarProduto($produto);
            http_response_code(201);
        } catch (Exception $e) {
            http_response_code(500);
        }
    }
}
