<?php

/*
    Cart Class
    Handle all tasks related to showing or modifying the number of items in cart

    The cart keeps track of user selected items using a session variable, $_SESSION['cart'].
    The session variable holds an array that contains the ids and the number selected of
    the products in the cart.

    $_SESSION['cart']['product_id'] = num of specific item in cart
*/


class Cart
{
  

    public function __construct()
    {
    }

    // -----------------------  Getters *START* -------------------------------


    // Return an array of all product info for items in the cart

    public function get()
    {
        if (isset($_SESSION['cart'])) {
            //get all product ids of items in cart
            $ids = $this->get_ids();

            // use list of ids to get product info from DB
            global $products;
            return $products->get_prod($ids);
        }
        return null;
    }

    // return an array of all product ids in cart

    public function get_ids()
    {
        if (isset($_SESSION['cart'])) {
    
            return array_keys($_SESSION['cart']);
        }
        return null;
    }



    // get total items in cart
    public function get_total_items()
    {
        $num = 0;

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $num = $num + $item;
            }
        }
        return $num;
    }

    // return the total cost of all items in cart

    public function get_total_cost()
    {
        $num = "0.00";

        if (isset($_SESSION['cart'])) {
            // if there are items to display
            $ids = $this->get_ids();

            // get product ids
            global $products;
            $prices = $products->get_prices($ids);

            // loop through, adding the cost of each item * the number of item
            // in the cart to $num each time

            if ($prices != null) {
                foreach ($prices as $price) {
                    $num  += doubleval($price['price'] * $_SESSION['cart'][$price['id']]);
                }
            }
        }
        return $num;
    }



    // return shipping cost based on item's weight 
    public function get_shipping_cost()
    {
        $products = $this->get();
        $shipping = 0;
        if (! empty($products)) {
            foreach ($products as $product) {
                if ($product['weight'] <= 200) {
                    $shipping += 1.00 * ($_SESSION['cart'][$product['id']]);
                } elseif ($product['weight'] <= 500) {
                    $shipping += 3.00 * ($_SESSION['cart'][$product['id']]);
                } elseif ($product['weight'] <= 800) {
                    $shipping += 5.00 * ($_SESSION['cart'][$product['id']]);
                } elseif ($product['weight'] <= 1000) {
                    $shipping += 8.00 * ($_SESSION['cart'][$product['id']]);
                } elseif ($product['weight'] <= 1500) {
                    $shipping += 8.00 * ($_SESSION['cart'][$product['id']]);
                } elseif ($product['weight'] <= 1500) {
                    $shipping += 8.00 * ($_SESSION['cart'][$product['id']]);
                } else {
                    $shipping += 20.00  * ($_SESSION['cart'][$product['id']]);
                }
            }
            return $shipping; 
        }
        else {
            return 0.00;
        }

    }




    // -----------------------  Getters *END* -------------------------------










    // -----------------------  Modifiers *START* -------------------------------


    /**
     * Adds item to the Cart
     * @param Type int,int
     * @return type null
     **/
    public function add($id, $num = 1)
    {
        // setup or retrieve cart
        $cart = array();
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
        }

        //check to see if item is already in cart
        if (isset($cart[$id])) {

            //if item is in cart
            $cart[$id] = $cart[$id] + $num;
        } else {
            //if item is not in cart
            $cart[$id] = $num;
        }
        $_SESSION['cart'] = $cart;
    }

    // clear the cart from items
    public function clear_cart()
    {
        unset($_SESSION['cart']);
    }



    // update the quantity of a specific item in the cart

    public function update($id, $num)
    {
        if ($num == 0) {
            unset($_SESSION['cart'][$id]);
            if (empty($_SESSION['cart'][$id])) {
                unset($_SESSION['cart']);
            }
        } else {
            $_SESSION['cart'][$id] = $num;
        }
    }

    // -----------------------  Modifiers *END* -------------------------------









    // -----------------------  Creators *START* -------------------------------


    // Return a string, containing list items for each product in cart

    public function create_cart()
    {
        // get products currently in cart

        $products = $this->get();

        $shipping = $this->get_shipping_cost();
        $data = '';
        $subtotal = 0;

        $data .= '<li class="header_row"><div class="col1">Product Name:</div>
                    <div class="col2">Quantity:</div><div class="col3">Product Price:</div>
                    <div class=col4>Total:</div></li>';

        if ($products != '') {
            //products to display

            $line = 1;
            foreach ($products as $product) {
                // create new item in cart
                $data .= '<li';
                if ($line % 2 == 0) {
                    $data .= 'class="alt"';
                }
                // displaying cart items(name, price,count)
                $data .= '><div  class="col1"><a href="' . SITE_PATH . 'product.php?id=' .  $product['id'] . '" >' . $product['name'] . '</a></div>';
                $data .= '<div class="col2"><input name="product' . $product['id'] . '" value="' . $_SESSION['cart'][$product['id']] . '"></div>';
                $data .= '<div class="col3">$' .number_format((float)($product['price']), 2, '.', '') . '</div>';
                $data .= '<div class="col4">$' . $product['price'] * $_SESSION['cart'][$product['id']] . '</div></li>';

                // calculating subtotal
                $subtotal += $product['price'] * $_SESSION['cart'][$product['id']];

                $line++;
            }

            // add subtotal row
            $data .= '<li class="subtotal_row"><div class="col1">Subtotal</div>
            <div class="col2">$' . number_format((float)($subtotal), 2, '.', '') . '</div></li>';

            // Tax row
            $data .= '<li class= "taxes_row"><div class="col1">Tax (%' . (TAX * 100) . ' )</div>
            <div class="col2">$' . number_format((float)(TAX * $subtotal), 2, '.', '') . '</div></li>';

            // Shipping row
            $data .= '<li class= "shipping_row"><div class="col1">Total Shipping Cost</div>
            <div class="col2">$' . number_format((float)($shipping), 2, '.', '')  . '</div></li>';


            // add total row
            $data .= '<li class="total_row"><div class="col1">Total</div>
             <div class="col2">$' . number_format((float)((TAX * $subtotal) + $subtotal) + $shipping, 2, '.', '')  . '</div></li>';
             
        } else {
            // no products to display
            $data .= '<li><strong>No items in the Cart!</strong></li>';

            // add subtotal row
            $data .= '<li class="subtotal_row"><div class="col1">Subtotal</div>
            <div class="col2">$0.00</div></li>';

            // Tax row
            $data .= '<li class= "taxes_row"><div class="col1">Tax (%' . (TAX * 100) . ' )</div>
              <div class="col2">$0.00</div></li>';

            // Shipping row
            $data .= '<li class= "shipping_row"><div class="col1">Total Shipping Cost</div>
                        <div class="col2">$0.00</div></li>';

            // add total row
            $data .= '<li class="total_row"><div class="col1">Total</div>
             <div class="col2">$0.00</div></li>';
        }


        return $data;
    }

    // -----------------------  Creators *END* -------------------------------
}
