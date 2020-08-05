<?php 

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Controllers\{
   AuthController
};

use Models\{
   Page
};

$app->get('/contact', function (Request $request, Response $response, $args) {

   $page = new Page();
      
   $view = $page->setTpl("contact");

   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());