<?php

namespace Models;

use DB\Sql;

class PaymentModel{

   public static function savePayment(
      string $user_uuid,
      string $cookie_id,
      string $amout,
      string $payment_id,
      string $status,
      string $status_detail,
      string $date_approved = "N/D",
      string $ticket_url = "N/D"
   ){
   
      $sql = new Sql();

      $sql->query(
         "INSERT INTO 
            orders(
               user_uuid,
               cookie_id,
               amout,
               payment_id,
               status,
               status_detail,
               date_approved,
               ticket_url
            ) 
         VALUES(
            :user_uuid,
            :cookie_id,
            :amout,
            :payment_id,
            :status,
            :status_detail,
            :date_approved,
            :ticket_url
         )",[
            ":user_uuid"=>$user_uuid,
            ":cookie_id"=>$cookie_id,
            ":amout"=>$amout,
            ":payment_id"=>$payment_id,
            ":status"=>$status,
            ":status_detail"=>$status_detail,
            ":date_approved"=>$date_approved,
            ":ticket_url"=>$ticket_url
         ]
      );

   }

}