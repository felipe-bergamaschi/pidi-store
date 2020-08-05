<?php

namespace Controllers;

use DB\Sql;

class CartController {

   public static function postVerify(
      array $post
   ){

      if (
         !isset($post["player-id"])  || trim($post["player-id"]) === "" ||
         !isset($post["amout"])      || trim($post["amout"]) === "" ||
         !isset($post["product-id"]) || trim($post["product-id"]) === ""
      ){
   
         return false;
   
      }
   
      $amout_array = array(1,2,3,4,5,6,7,8,9,10);
   
      if (
         !is_numeric($post["product-id"]) ||
         !is_numeric($post["amout"]) ||
         !in_array($post["amout"], $amout_array)
      ){
         
         return false;

      }

   }
   
   public static function cartProductList(){
      
      $sql = new Sql();

      $request = $sql->select(
         "SELECT 
            cart._id,
            cart.player_id,
            cart.product_id,
            cart.amout,
            productS.product_name,
            productS.value,
            productS.qtd
         FROM 
            cart
         JOIN
            productS
         WHERE
            session_id = :session_id &&
            products._id = cart.product_id &&
            productS.status = 1
         ",[
            ":session_id"=>$_SESSION[SESSION_NAME]["_id"]
         ]
      );

      return $request;

   }

   public static function removeProductFromCart(
      int $product_id
   ){
      
      $user_id = $_SESSION[SESSION_NAME]["_id"];

      $sql = new Sql();

      $sql->query(
         "DELETE FROM 
            cart 
         WHERE 
            _id = :_id &&
            session_id = :session_id
         ",[
            ":_id"=>$product_id,
            ":session_id"=>$user_id
         ]
      );

   }

   public static function updateProductFromCart(
      int $_id,
      int $amout
   ){
      
      $user_id = $_SESSION[SESSION_NAME]["_id"];
      
      $sql = new Sql();

      $sql->query(
         "UPDATE 
            cart 
         SET 
            amout = :amout
         WHERE
            _id = :_id &&
            session_id = :session_id
         ",[
            ":amout"=>$amout,
            ":_id"=>$_id,
            ":session_id"=>$user_id
         ]
      );

   }

}