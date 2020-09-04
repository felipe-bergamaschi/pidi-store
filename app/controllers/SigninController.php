<?php

namespace Controllers;

use DB\Sql;

class SigninController{

   public static function checkInputSignin(
      array $input
   ){

      if (
         !isset($input["email"]) || trim($input["email"]) === "" ||
         !isset($input["password"]) || trim($input["password"]) === ""
      ){
   
         return false;
   
      }
   
      return true;

	} 

   public static function checkSignin(
      string $email,
      string $password
   ){
      
      $sql = new Sql();

      $request = $sql->select(
         "SELECT 
            uuid,
            username,
            image,
            password 
         FROM 
            user 
         WHERE 
            email = :email
         ",[
            ":email"=>$email
         ]
      );

      if (
         (int)count($request) !== (int)1
      ){

         return false;

      }

      if (
         !password_verify($password, $request[0]["password"])
      ){
         
         return false;

      }

      SigninController::createSession(
         $request[0]["uuid"],
         $email,
         $request[0]["username"],
         $request[0]["image"]
      );

   }

   public static function createSession(
      string $uuid,
      string $email,
      string $username,
      string $image
   ){

      $_SESSION[SESSION_NAME]["uuid"] = $uuid;
      $_SESSION[SESSION_NAME]["email"] = $email;
      $_SESSION[SESSION_NAME]["username"] = $username;
      $_SESSION[SESSION_NAME]["image"] = $image;

      return true;

   }

   public static function sessionVerify(){

      if (   
         !isset($_SESSION[SESSION_NAME]["_id"]) ||
         !isset($_SESSION[SESSION_NAME]["uuid"]) ||
         !isset($_SESSION[SESSION_NAME]["email"]) ||
         !isset($_SESSION[SESSION_NAME]["username"])
      ){

         setError('Você precisa estar autenticado para poder acessar esta página');
         header('location: /signin');
         exit();

      }

      return true;

   }

}