
<?php

include('app/init.php');

    $template->set_data('page_class', 'product');


    // to show product details 

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // show product
    
        $product = $products->get_prod($_GET['id']);
        
        if (!empty($product)) {
            // pass product data to view
            $template->set_data('prod_id', $_GET['id']);
            $template->set_data('prod_name', $product['name']);
            $template->set_data('prod_description', $product['description']);
            $template->set_data('prod_price', $product['price']);
            $template->set_data('prod_image', IMAGE_PATH . $product['image']);
            $template->set_data('prod_weight', $product['weight']);
       
            // create category nav
            $category_nav = $categories->create_category_nav($product['category_name']);
            $template->set_data('page_nav', $category_nav);

            // display view
            $template->load('app\views\v_products.php', $product['name']);
        } 
         else {
             // error
             $template->redirect(SITE_PATH);
         }
     } else {
         // error
         $template->redirect(SITE_PATH);
    }
