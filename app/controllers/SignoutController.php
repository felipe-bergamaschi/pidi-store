<?php

namespace Controllers;

class SignoutController{

   public static function deleteSession(){

      setcookie(COOKIE_NAME, "", time() - 3600);

      unset($_SESSION[SESSION_NAME]["_id"]);

   }  

}