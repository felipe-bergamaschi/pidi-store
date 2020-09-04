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

$app->get('/password-hash', function (Request $request, Response $response, $args) {

   $timeTarget = 0.05; 

   $cost = 8;
   do {
      $cost++;
      $start = microtime(true);
      password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
      $end = microtime(true);
   } while (($end - $start) < $timeTarget);

   $view = $cost;

   $response->getBody()->write("$view");

   return $response; 

});

$app->get('/api-whatsapp', function (Request $request, Response $response, $args) {

   if (whatsappLink() === true) {
	 	
      header("location: https://api.whatsapp.com/send?phone=5575991172929&text=Olá%2C+estou+entrando+em+contato+pelo+site");
      exit();
   
   } 
   
   header("location: https://web.whatsapp.com/send?phone=5575991172929&text=Olá%2C+estou+entrando+em+contato+pelo+site");	
   exit(); 

});