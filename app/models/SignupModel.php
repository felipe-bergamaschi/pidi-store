<?php

namespace Models;

use DB\Sql;
use Ramsey\Uuid\Uuid;

class SignupModel {

   public static function save(
      array $input
   ){    

      $uuid = Uuid::uuid1();

      $options = [
         'cost' => PASSWORD_COST
      ];
      
      $password = password_hash($input["password"], PASSWORD_BCRYPT, $options);

      $image = "https://api.adorable.io/avatars/150/".$uuid->toString();

      $sql = new Sql();

      $sql->query(
         "INSERT INTO 
            user(
               uuid, 
               username, 
               email, 
               password,
               image
            )
         VALUES(
            :uuid, 
            :username, 
            :email, 
            :password,
            :image
         )",[
            ":uuid"=>$uuid->toString(), 
            ":username"=>$input["username"], 
            ":email"=>$input["email"], 
            ":password"=>$password,
            ":image"=>$image
         ]
      );

   }

}