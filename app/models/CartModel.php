<?php

namespace Models;

use DB\Sql;

class CartModel {

   public static function addToCart(
      string $session_id,
      string $player_id,
      int $product_id,
      int $amout
   ){
      
      $sql = new Sql();

      $sql->query(
         "INSERT INTO 
            cart(
               session_id, 
               player_id, 
               product_id, 
               amout
            )
         VALUES(
            :session_id, 
            :player_id, 
            :product_id, 
            :amout
         )",[
            ":session_id"=>$session_id, 
            ":player_id"=>$player_id, 
            ":product_id"=>$product_id, 
            ":amout"=>$amout,
         ]
      );

   }

}