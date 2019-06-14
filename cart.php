<?php


// old 
include('app\init.php');

$template->set_data('page_class', 'shoppingcart');

// check if user is logged in
if (isset($_SESSION['username'])) :

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    //check if adding valid item
    if (!$products->product_exist($_GET['id'])) {
        $template->set_alert('invalid item!');
        $template->redirect(SITE_PATH . 'cart.php');
    }

    // add items to the cart
    if (isset($_GET['num']) && is_numeric($_GET['id'])) {
        $cart->add($_GET['id'], $_GET['num']);
        $template->set_alert('items have been added to the cart!');
    } else {
        $cart->add($_GET['id']);
        $template->set_alert('item has been added');
        $template->redirect(SITE_PATH . 'cart.php');
    }
}
if (isset($_GET['empty'])) {
    $cart->clear_cart();
    $template->set_data('cart_total_items',0  );
    $template->set_alert('cart emptied');
    $template->redirect(SITE_PATH . 'cart.php');
}

if (isset($_POST['update'])) {
      // get all ids of products in cart

      $ids = $cart->get_ids(); 
      
      //make sure we have ids to work with
      if ($ids != Null) {
          foreach ($ids as $id) {
              $cart->update($id, $_POST['product'.$id]);
          }
      }

      // add alert
      if (empty($_SESSION['cart'])) {
        $template->set_alert('No items in Cart!');
      }
      else {
        $template->set_alert('Number of items in the cart updated!');
      }
     
      $template->set_data('cart_total_items', $cart->get_total_items());
      $template->set_data('cart_total_cost', $cart->get_total_cost());

}

/// get items in cart
$display = $cart->create_cart();
$template->set_data('cart_rows', $display);

endif;

// if user is not logged in 
if (!isset($_SESSION['username'])) {
    $template->set_alert('you must log in first' , 'error');
}

// create category nav
$category_nav = $categories->create_category_nav();
$template->set_data('page_nav', $category_nav);

$template->load('app\views\v_cart.php', 'Shopping Cart');  
//endif;