<?php

function sumValue($value, $amout){
   
   $sum = ($value * $amout);

   echo $sum;

}

function totalPrice($values){
   
   $prices = "";

   for ($i=0; $i < count($values); $i++) { 
      
      $prices .= ($values[$i]["amout"] * $values[$i]["value"])."/";

   }

   $prices = explode("/", $prices);
   
   array_pop($prices);

   $prices = array_sum($prices);

   return $prices;

}

function validateEmail($email){
        
   if (!preg_match('/^[A-Za-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/', $email)) {
           
      return false;
   
   }   

   return true;

}

function validatePassword($password){
   
   if(trim(strlen($password)) >= 21){
       
      return false;

   }

   return true;

}

function validateUsername($username){
   
   if(!trim(preg_match('/^[A-Za-zãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ ]+$/u', $username))){
       
      return false;

   }   

   return true;

}

function statusReturn($status){

   if    ($status === "approved"){ return "Aprovado"; }
   elseif($status === "in_process"){ return "Em processo"; }
   elseif($status === "rejected"){ return "Rejeitado"; }
   elseif($status === "pending"){ return "Aguardando pagamento"; }


}