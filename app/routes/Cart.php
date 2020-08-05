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

$app->post('/add-cart', function (Request $request, Response $response, $args) {

   $cart_controller = new CartController();
   
   $post_verify = $cart_controller->postVerify($_POST);

   if ($post_verify === false){

      setError('Preencha todos os dados corretamente');
      header('location: /product-details/'.$_POST["product-id"]);
      exit();

   }

   $cart_model = new CartModel();

   $cart_model->addToCart(
      $_SESSION[SESSION_NAME]["_id"],
      $_POST["player-id"],
      $_POST["product-id"],
      $_POST["amout"]
   );

   setSuccess('Adicionado ao carrinho');
   header('location: /product-details/'.$_POST["product-id"]);
   exit();

})->add(new AuthController());

$app->get('/my-cart', function (Request $request, Response $response, $args) {

   $cart = new CartController();

   $product_list = $cart->cartProductList();

   $total_price = totalPrice($product_list);

   $page = new Page();
      
   $view = $page->setTpl("cart",[
      "product_list"=>$product_list,
      "total_price"=>$total_price,
      "msgSuccess"=>getSuccess(),
      "msgError"=>getError()
   ]);

   $response->getBody()->write("$view");

   return $response; 

})->add(new AuthController());

$app->get('/my-cart/{data}/update', function (Request $request, Response $response, $args) {

   $data = explode("-", $args["data"]);

   $_id = $data[0];
   $amout = $data[1];

   if (!in_array($amout, [1,2,3,4,5,6,7,8,9,10])){

      setError('Informe os dados corretamente');
      header('location: /my-cart');
      exit();

   }

   $cart = new CartController();

   $cart->updateProductFromCart(
      $_id,
      $amout
   );

  setSuccess('Produto atualizado com sucesso');
  header('location: /my-cart');
  exit();

})->add(new AuthController());

$app->get('/my-cart/{product-id}/delete', function (Request $request, Response $response, $args) {

   $cart = new CartController();

   $cart->removeProductFromCart($args["product-id"]);

  setSuccess('Produto removido com sucesso');
  header('location: /my-cart');
  exit();

})->add(new AuthController());
