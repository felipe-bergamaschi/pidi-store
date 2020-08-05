<?php

namespace Controllers;

use DB\Sql;

class Products{

   public static function listAll(){
      
      $sql = new Sql();

      $request = $sql->select(
         "SELECT * FROM 
            products 
         ORDER BY 
            RAND()"
      );

      return $request;

   }

   public static function productList(
      int $product_id
   ){
      
      $sql = new Sql();

      $request = $sql->select(
         "SELECT * FROM 
            products 
         WHERE 
            _id = :_id
         ",[
            ":_id"=>$product_id
         ]
      );

      return count($request) === 0 ? false : $request[0];

   }

}