<?php

namespace Models;

use DB\Sql;
use Ramsey\Uuid\Uuid;

class SignupModel {

   public static function save(
      array $input
   ){ 

      $uuid = Uuid::uuid1();

      $sql = new Sql();

      $sql->query(
         "INSERT INTO 
            user(
               uuid, 
               username, 
               email, 
               password
            )
         VALUES(
            :uuid, 
            :username, 
            :email, 
            :password
         )",[
            ":uuid"=>$uuid->toString(), 
            ":username"=>$input["username"], 
            ":email"=>$input["email"], 
            ":password"=>$input["password"],
         ]
      );

   }

}