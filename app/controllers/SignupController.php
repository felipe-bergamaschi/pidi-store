<?php

namespace Controllers;

use DB\Sql;

class SignupController{

   public static function checkSignup(
      array $input
   ) {

      if (
         !isset($input["username"]) || trim($input["username"]) === "" ||
         !isset($input["email"]) || trim($input["email"]) === "" ||
         !isset($input["password"]) || trim($input["password"]) === "" ||
         !isset($input["confirm-password"]) || trim($input["confirm-password"]) === ""
      ){
   
         return false;
   
      }
   
      if (
         !validateEmail($input["email"]) || 
         !validatePassword($input["password"]) ||
         !validateUsername($input["username"])
      ){
   
        return false;
   
      }

      if (
         $input["password"] !== $input["confirm-password"]
      ){

         return false;

      }

      return true;

	} 

   public static function checkEmail(
      string $email
   ){
      
      $sql = new Sql();

      $request = $sql->select(
         "SELECT 
            count(uuid) as count 
         FROM 
            user 
         WHERE 
            email = :email
         ",[
            ":email"=>$email
         ]
      );

      $count = $request[0]["count"];

      if (
         (int)$count !== (int)0
      ){

         return false;

      }

      return true;

   }

}