<?php 

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Controllers\{
   Products
};

use Models\{
   Page
};

$app->get('/product-details/{product-id}', function (Request $request, Response $response, $args) {

   $products = new Products();

   $productDetails = $products->productList(
      $args["product-id"]
   );

   if ($productDetails === false){

      header('location: /');
      exit();

   }

   $productList = $products->listAll(); 

   $page = new Page();
      
   $view = $page->setTpl("product-details",[
      "productID"=>$args["product-id"],
      "productList"=>$productList,
      "productDetails"=>$productDetails,
      "msgSuccess"=>getSuccess(),
      "msgError"=>getError()
   ]);

   $response->getBody()->write("$view");

   return $response; 

});