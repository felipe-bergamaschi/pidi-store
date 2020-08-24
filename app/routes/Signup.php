<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Controllers\{
   AuthController,
   SignupController
};

use Models\{
   Page,
   SignupModel
};

$app->get('/signup', function (Request $request, Response $response, $args) {

   $page = new Page([
      "header"=>false,
      "footer"=>false
   ]);

   $view = $page->setTpl("signup",[
      "msgSuccess"=>getSuccess(),
      "msgError"=>getError()
   ]);
      
   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());

$app->post('/signup', function (Request $request, Response $response, $args) {

   $signupController = new SignupController();

   $checkSignup = $signupController->checkSignup($_POST);

   if ($checkSignup === false){

      setError('Preencha todos os dados corretamente');
      header('location: /signup');
      exit();

   }

   $checkEmail = $signupController->checkEmail($_POST["email"]);

   if ($checkEmail === false){

      setError('O email já está sendo utilizado por outro usuário');
      header('location: /signup');
      exit();

   }

   $signupModel = new SignupModel();

   $signupModel->save($_POST);

   setSuccess('Cadastro realizado com sucesso');
   header('location: /signin');
   exit();

})->add(new AuthController());
