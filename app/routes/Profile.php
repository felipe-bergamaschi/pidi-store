<?php 

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Controllers\{
   AuthController,
   OrdersController,
   SigninController
};

use Models\{
   Page
};

$app->get('/profile', function (Request $request, Response $response, $args) {

   SigninController::sessionVerify();

   $orders = new OrdersController();

   $order_list = $orders->orderList();

   $page = new Page();
      
   $view = $page->setTpl("order-list",[
      "order_list"=>$order_list,
      "msgSuccess"=>getSuccess(),
      "msgError"=>getError()
   ]);

   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());

$app->get('/profile/{order-id}/order', function (Request $request, Response $response, $args) {

   SigninController::sessionVerify();

   $orders = new OrdersController();

   $order_detail = $orders->orderDetail(
      $args["order-id"]
   );

   $page = new Page();
      
   $view = $page->setTpl("order-detail",[
      "order_detail"=>$order_detail,
      "msgSuccess"=>getSuccess(),
      "msgError"=>getError()
   ]);

   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());
