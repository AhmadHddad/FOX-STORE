

<?php
session_start();

// if user wants to log out then sessoin destroy 
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
}

// error reporting
mysqli_report(MYSQLI_REPORT_ERROR);
ini_set('display_errors', 1);


//setting up constants

define('SITE_NAME', 'FOX store');
define('SITE_PATH', 'http://localhost:80/fox/');
define('IMAGE_PATH', 'http://localhost:80/fox/resources/images/');
define('TAX','0.16');
// Paypal definitions 
define('PAYPAL_MODE','sandbox');
define('PAYPAL_CURRENCY','USD');
define('PAYPAL_DEVID','AaKaEmBZJQONrPQWZCT6Tfas75ekmf0SHSQbe9DC7sHjNUCI2Kj4Xt6WZKRRTWk7goGQ6bX4EWR-chkv');
define('PAYPAL_DEVSECRET','EBEg5FqjCjO6gL1rkwqpSgmUxkanBtJphigCBA4ZePVtDBh_5kuyvQWPPxkUEnGdW1jDhu_iU3LPC9jm');
define('PAYPAL_LIVEID','');
define('PAYPAL_LIVESECRET','');


// including  obj
require_once('models\m_dbCon.php');
include('models\m_template.php');
include('models\m_categories.php');
include('models\m_products.php');
include('models\m_cart.php');



// creating obj
$template = new Template();
$db = new DB();
$categories = new Categories();
$products = new Products();
$cart = new Cart();

// Global 

 $template->set_data('cart_total_items', $cart->get_total_items());
 $template->set_data('cart_total_cost', $cart->get_total_cost());
