<?php

namespace Controllers;

use DB\Sql;

class OrdersController {

   public static function orderList(){
      
      $sql = new Sql();

      $request = $sql->select(
         "SELECT * FROM 
            orders
         WHERE
            user_uuid = :user_uuid
         ORDER BY
            _id
         DESC
         ",[
            ":user_uuid"=>$_SESSION[SESSION_NAME]["uuid"]
         ]
      );

      return $request;

   }

   public static function orderDetail(
      string $order_id
   ){
      
      $sql = new Sql();

      $request = $sql->select(
         "SELECT 
            cart._id,
            cart.player_id,
            cart.product_id,
            cart.amout,
            products.product_name,
            products.value,
            products.qtd
         FROM 
            cart
         JOIN
            products
         WHERE
            cart.session_id = :session_id &&
            cart.status = 1 &&
            products._id = cart.product_id &&
            productS.status = 1
         ",[
            ":session_id"=>$order_id
         ]
      );

      return $request;

   }

}