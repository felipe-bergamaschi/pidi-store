<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Ramsey\Uuid\Uuid;

class AuthController{

   public function __invoke(
      Request $request, 
      RequestHandler $handler
   ): Response {

		if (
         !isset($_SESSION[SESSION_NAME]["_id"]) ||
         !$_SESSION[SESSION_NAME]["_id"]
      ){

         if (
            !isset($_COOKIE[COOKIE_NAME])
         ){

            $_id = Uuid::uuid1();

            setcookie(
               COOKIE_NAME, 
               $_id->toString(), 
               time() + (86400 * 30)
            );

            $_SESSION[SESSION_NAME]["_id"] = $_id->toString();
         
         } else{

            $_SESSION[SESSION_NAME]["_id"] = $_COOKIE[COOKIE_NAME];

         }

      } 
      
      $response = $handler->handle($request);
      return $response;

   } 
   
   public static function deleteSession(){

      setcookie(COOKIE_NAME, "", time() - 3600);

      unset($_SESSION[SESSION_NAME]["_id"]);

   }  

}