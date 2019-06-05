<?php

   
include('app\init.php');

if (isset($_POST)) {
    // create payment object
    include('models/m_payments.php');
    $payments = new Payments();

    // get item data
    $items = $cart->get();

    // get details
    $details['subtotal'] = $cart->get_total_cost();
    $details['shipping'] =  number_format((float)($cart->get_shipping_cost()), 2, '.', '');
    $details['tax'] = number_format((float)($details['subtotal'] * TAX), 2, '.', '');
    $details['total'] =  number_format((float)($details['subtotal']+$details['shipping']+$details['tax']), 2, '.', '');

    //send to paypal
        $err = $payments->create_payment($items,$details);
        if ($err != null) {
            $template->set_alert($err, "error");
            $template->redirect('cart.php');
        }
}

else{
    $template->redirect('cart.php');
}
