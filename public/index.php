<?php

header('Content_Type: application/json');

require_once '../controller/ProdutosController.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch($uri){
    case '/produtos':
        if($method == 'POST'){
            $teste = new ProdutosController();
            $teste->criarProduto();

        }else{
            http_response_code(405);
        }
    //case '/compras':{}

    }

