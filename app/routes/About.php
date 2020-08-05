<?php 

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Controllers\{
   AuthController
};

use Models\{
   Page
};

$app->get('/about', function (Request $request, Response $response, $args) {

   $page = new Page();
      
   $view = $page->setTpl("about");

   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());