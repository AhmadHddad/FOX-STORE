<?php
include('/logincheck.php');
include('app\init.php');

$template->set_data('page_class', 'success');

// create payment obj
include('models/m_payments.php');
$payments = new Payments();

// execute payment to finalize
$payer_id = htmlspecialchars($_GET['PayerID']);
$payment_Id = $_GET['paymentId'];
$result = $payments->payment_execute($payment_Id,$payer_id);

$cart->clear_cart();
$template->set_data('cart_total_items', 0);
$template->set_data('cart_total_cost', 0);
$template->set_data('name', $result->payer->payer_info->first_name . ' '.$result->payer->payer_info->last_name );
// create category nav
$category_nav = $categories->create_category_nav();
$template->set_data('page_nav', $category_nav);

$template->load('app\views\v_success.php', 'Thanks!');  
