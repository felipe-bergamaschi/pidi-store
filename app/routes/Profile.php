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

$app->get('/profile', function (Request $request, Response $response, $args) {

   print_r($_SESSION);
   print_r($_COOKIE);
      
   $view = "";

   $response->getBody()->write("$view");

   return $response; 

});
