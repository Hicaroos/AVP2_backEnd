<?php

require_once '../model/comprasDAO.php';
require_once '../model/comprasModel.php';
require_once '../model/produtosDAO.php';
require_once '../model/jurosDAO.php';

class ComprarController
{

    public function salvarCompras()
    {
        $dao = new ComprasDAO();
        $produto = new ProdutosDAO();
        $juros = new JurosDAO();

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

        $validIdProduto = $produto->validarIdProduto($dados['idProduto']);
        if(!$validIdProduto){
            http_response_code(422);
            return;
        }

        $valor = $dao->buscarValorProduto($dados['idProduto']);
        $valorParcela = 0.0;
        $jurosAplicado = 0.0;

        if($dados['qtdParcelas'] > 0){
            $valorParcela = ($valor - $dados['valorEntrada']) / $dados['qtdParcelas'];
        }
        
        if($dados['qtdParcelas'] > 6){
            $valorJuros = $juros->mostrarJuros();
            $jurosSelic = $valorJuros / 100;
            $valorFinanciamento = $valor - $dados['valorEntrada'];
            $valorComJuros = $valorFinanciamento * ($jurosSelic + 1);
            $jurosAplicado = $valorComJuros - $valorFinanciamento;
            $valorParcela = $valorComJuros / $dados['qtdParcelas'];
        }

        try {
            $compra = new Compras($dados['idProduto'], $dados['valorEntrada'], $dados['qtdParcelas'],$valorParcela);
            $compra->setJurosAplicado($jurosAplicado);
            $dao->comprar($compra);

            http_response_code(201);

        } catch (Exception $e) {
            http_response_code(404);
        }
    }
}
