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