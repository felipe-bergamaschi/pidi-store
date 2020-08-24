<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Controllers\{
   AuthController,
   CartController
};

use Models\{
   Page,
   CartModel
};

$app->get('/signin', function (Request $request, Response $response, $args) {

   $page = new Page([
      "header"=>false,
      "footer"=>false
   ]);

   $view = $page->setTpl("signin");
      
   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());
