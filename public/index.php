<?php

header('Content_Type: application/json');

require_once '../controller/ProdutosController.php';
require_once '../controller/comprarController.php';

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
        break;
        
    case '/compras':{
        if($method == 'POST'){
            $compras = new ComprarController();
            $compras->store();
        }else{
            http_response_code(405);
        }
        break;
    }
    }

