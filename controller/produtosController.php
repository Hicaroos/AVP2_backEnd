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
        if (!is_string($dados['nome']) || !is_numeric($dados['valor'])) {
            http_response_code(422);
            return;
        }
        if(isset($dados['tipo'])){
            if (!is_string($dados['tipo'])){
                http_response_code(422);
                return;
            }
        }

        $dao = new ProdutosDAO();

        $validNomeProduto = $dao->validarNomeProduto($dados['nome']);
        if ($validNomeProduto) {
            http_response_code(422);
            return;
        }

        try {
            $produto = new Produtos($dados['nome'], $dados['valor']);
            if (isset($dados['tipo'])) {
                $produto->setTipo($dados['tipo']);
            }

            $dao->cadastrarProduto($produto);
            http_response_code(201);
        } catch (Exception $e) {
            http_response_code(500);
        }
    }
}
