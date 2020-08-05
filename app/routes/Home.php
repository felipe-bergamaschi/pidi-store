<?php 

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Controllers\{
   AuthController,
   Products
};

use Models\{
   Page
};

$app->get('/', function (Request $request, Response $response, $args) {

   $products = new Products();

   $productList = $products->listAll(); 

   $page = new Page();
      
   $view = $page->setTpl("index",[
      "productList"=>$productList
   ]);

   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());