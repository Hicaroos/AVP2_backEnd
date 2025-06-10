<?php

require_once '../model/ProdutosDAO.php';

class ProdutosController
{

    public function salvarProduto()
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

        $dao = new ProdutosDAO();

        $validNomeProduto = $dao->validarNomeProduto($dados['nome']);
        if ($validNomeProduto) {
            http_response_code(422);
            return;
        }

        try {
            $produto = new Produtos($dados['nome'], $dados['tipo'], $dados['valor']);
            
            $dao->cadastrarProduto($produto);
            http_response_code(201);
        } catch (Exception $e) {
            http_response_code(500);
        }
    }
}
