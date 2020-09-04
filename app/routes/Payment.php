<?php 

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Controllers\{
   AuthController,
   SigninController,
   CartController,
   SignoutController
};

use Models\{
   Page,
   PaymentModel
};

$app->get('/payment', function (Request $request, Response $response, $args) {

   SigninController::sessionVerify();

   $cart = new CartController();

   $product_list = $cart->cartProductList();

   $total_price = totalPrice($product_list);

   if ($total_price === 0){

      setError('O carrinho está vazio');
      header('location: /my-cart');
      exit();

   }

   $page = new Page();

   $view = $page->setTpl("payment",[
      "public_key"=>getenv("MERCADO_PAGO_PUBLIC_KEY"),
      "total_price"=>$total_price,
      "email"=>$_SESSION[SESSION_NAME]["email"],
      "msgSuccess"=>getSuccess(),
      "msgError"=>getError()
   ]);
      
   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());

$app->post('/payment', function (Request $request, Response $response, $args) {

   SigninController::sessionVerify();

   if (
      !isset($_POST["token"]) || trim($_POST["token"]) === "" ||
      !isset($_POST["payment_method_id"]) || trim($_POST["payment_method_id"]) === ""
   ){

      setError('Pagamento falhou, tente novamente');
      header('location: /payment');
      exit();

   }

   $cart = new CartController();

   $product_list = $cart->cartProductList();

   $total_price = totalPrice($product_list);

   if ($total_price === 0){

      setError('O carrinho está vazio');
      header('location: /my-cart');
      exit();

   }

   $access_token = getenv("MERCADO_PAGO_ACCESS_TOKEN");

   MercadoPago\SDK::setAccessToken($access_token);

   $payment = new MercadoPago\Payment();
   
   $payment->transaction_amount = $total_price;
   $payment->token              = $_POST["token"];
   $payment->description        = "Compra na PidiStore";
   $payment->installments       = 1;
   $payment->payment_method_id  = $_POST["payment_method_id"];
   $payment->payer = array(
      "email"=>$_SESSION[SESSION_NAME]["email"]
   );

   $payment->save();

   $status = $payment->status;

   if (
      !in_array(
         $status, [
            "approved",
            "in_process",
            "in_process",
            "rejected"
         ]
      )
   ){

      setError('Pagamento falhou, tente novamente');
      header('location: /payment');
      exit();

   }

   $payment_model = new PaymentModel();

   $payment_model->savePayment(
      $_SESSION[SESSION_NAME]["uuid"],
      $_SESSION[SESSION_NAME]["_id"],
      $payment->id,
      $payment->status,
      $payment->status_detail,
      $payment->date_approved
   );

   CartController::cartUpdate();

   SignoutController::deleteSession();
   
   setSuccess('Pagamento realizado com sucesso');
   header('location: /profile');
   exit();

});

$app->post('/payment/ticket', function (Request $request, Response $response, $args) {

   SigninController::sessionVerify();

   if (
      !isset($_POST["first_name"]) || trim($_POST["first_name"]) === "" ||
      !isset($_POST["last_name"]) || trim($_POST["last_name"]) === "" ||
      !isset($_POST["cpf"]) || trim($_POST["cpf"]) === ""
   ){

      setError('Pagamento falhou, tente novamente');
      header('location: /payment');
      exit();

   }

   $cart = new CartController();

   $product_list = $cart->cartProductList();

   $total_price = totalPrice($product_list);

   if ($total_price === 0){

      setError('O carrinho está vazio');
      header('location: /my-cart');
      exit();

   }

   $access_token = getenv("MERCADO_PAGO_ACCESS_TOKEN");
   
   MercadoPago\SDK::setAccessToken($access_token);
   
   $payment_methods = MercadoPago\SDK::get("/v1/payment_methods");

   $payment = new MercadoPago\Payment();
   
   $payment->transaction_amount = $total_price;
   $payment->description        = "Compra na PidiStore";
   $payment->payment_method_id  = "bolbradesco";
   $payment->payer = array(
      "email" => $_SESSION[SESSION_NAME]["email"],
      "first_name" => $_POST["first_name"],
      "last_name" => $_POST["last_name"],
      "identification" => array(
         "type" => "CPF",
         "number" => $_POST["cpf"]
      )
   );

   $payment->save();

   $status = $payment->status;

   if ($status != "pending"){

      setError('Pagamento falou, tente novamente');
      header('location: /payment');
      exit();

   }
   
   $payment_model = new PaymentModel();

   $payment_model->savePayment(
      $_SESSION[SESSION_NAME]["uuid"],
      $_SESSION[SESSION_NAME]["_id"],
      $payment->id,
      $payment->status,
      $payment->status_detail,
      "N/D",
      $payment->transaction_details->external_resource_url
   );

   CartController::cartUpdate();

   SignoutController::deleteSession();
   
   setSuccess('Pagamento realizado com sucesso');
   header('location: /profile');
   exit();

});