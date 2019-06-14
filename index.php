<?php
//expanding mysql connection time out so we keep db on;
ini_set('mysql.connect_timeout', 3000);
ini_set('default_socket_timeout', 3000);

include('app\init.php');

$template->set_data('page_class', 'home');




if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // get products from specific category
    
    $category = $categories->get_categories($_GET['id']);
    
    // check if valid
    if (! empty($category)) {
        // get category nav
        $category_nav = $categories->create_category_nav($category['name']);
        $template->set_data('page_nav', $category_nav);
        
        
        // get all products from that category
        $cat_products = $products->create_product_table(4, $_GET['id']);

        if (! empty($cat_products)) {
            $template->set_data('prod_table', $cat_products);
        } else {
            $template->set_data('prod_table', '<li>No products exist in this category!</li>');
        }
        $template->load('app\views\v_home.php', $category['name']);
    } else {
        // if category isn't valid
        $template->redirect(SITE_PATH);
    }
} else {
    // get all products from all categories
    
    // get category nav
    $category_nav = $categories->create_category_nav('home');
    $template->set_data('page_nav', $category_nav);
    
    // get products
    $prod = $products->create_product_table();
    $template->set_data('prod_table', $prod);
    
    $template->load('app\views\v_home.php', 'FOX STore');
}   

