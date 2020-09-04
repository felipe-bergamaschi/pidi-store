<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Controllers\{
   AuthController,
   SigninController
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

   $view = $page->setTpl("signin",[
      "msgSuccess"=>getSuccess(),
      "msgError"=>getError()
   ]);
      
   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());

$app->post('/signin', function (Request $request, Response $response, $args) {

   $signinController = new SigninController();

   $checkInputSignin = $signinController->checkInputSignin($_POST);

   if ($checkInputSignin === false){

      setError('Preencha todos os dados corretamente');
      header('location: /signin');
      exit();

   }

   $checkSignin = $signinController->checkSignin(
      $_POST["email"],
      $_POST["password"]
   );

   if ($checkSignin === false){

      setError('Preencha todos os dados corretamente');
      header('location: /signin');
      exit();

   }

   header('location: /');
   exit();

})->add(new AuthController());
