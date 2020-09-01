<?php

if (!isset($_SESSION)){
   session_start();
}

use Slim\Factory\AppFactory;

require 'vendor/autoload.php';

const SESSION_NAME = "user-data";
const COOKIE_NAME  = "user-id";
const PASSWORD_COST = 10;

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// HOME 
require "app/routes/Home.php";

// ABOUT 
require "app/routes/About.php";

// CONTACT 
require "app/routes/Contact.php";

// PRODUCT DETAILS
require "app/routes/ProductDetails.php";

// CART
require "app/routes/Cart.php";

// PAYMENT
require "app/routes/Payment.php";

// SIGNUP
require "app/routes/Signup.php";

// SIGNIN
require "app/routes/Signin.php";

// ALERTS
require "app/functions/alerts.php";

// FUNCTIONS
require "app/functions/functions.php";

// KEYS
require "keys.php";

$app->run();