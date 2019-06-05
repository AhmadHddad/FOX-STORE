<?php

class Products
{
    private $db1_table = 'products';
    private $db2_table = 'categories';
    public function __construct()
    { }



    // -----------------------  Getters *START* -------------------------------


    // get products from dataBase by query, filter by $id or get all products
    public function get_prod($id = null)
    {

        global $DataBase;

        $data = array();
        if (is_array($id)) {
            // echo 'fucl you from if arr';

            // get the products based on array of $id
            $items = '';
            foreach ($id as $item) {
                if ($items != '') {
                    $items .= ',';
                }
                $items .= $item;
            }

            $result = $DataBase->query('SELECT id, name, description, price, 
            image,weight From products WHERE id IN (' . $items . ')');

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {
                    $data[] = array(
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'description' => $row['description'],
                        'price' => $row['price'],
                        'image' => $row['image'],
                        'weight' => $row['weight'],
                        'quantity'=>$_SESSION['cart'][$row['id']]
                    );
                }
            }
        } elseif ($id != null) {
            //echo "fuck your from elseif 1";

            // get one specific products based on one id 
            $stmt = $DataBase->prepare("SELECT products.id,products.name,products.description,products.price,
            products.image,products.weight,products.category_id,categories.name
            FROM products JOIN categories ON products.category_id  WHERE products.id = ? AND products.category_id = categories.id ");

            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($prod_id, $prod_name, $prod_description, $prod_price, $prod_image, $prod_weight, $prod_catID, $category_name);
                $stmt->fetch();


                if ($stmt->num_rows > 0) {
                    $data =  array('id' => $prod_id, 'name' => $prod_name, 'description' => $prod_description, 'price' => $prod_price, 'image' => $prod_image, 'weight'=>$prod_weight, 'category_name' => $category_name, 'prod_catId' => $prod_catID);
                }
                $stmt->close();
            }
        } else {
            // echo "fuck you from else all";

            // get all products in the DB
            $result = $DataBase->query("SELECT * FROM " . $this->db1_table . " ORDER BY NAME");

            if ($result->num_rows > 0) {
                while ($row =  $result->fetch_array()) {
                    $data[] = array(
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'description' => $row['description'],
                        'price' => $row['price'],
                        'image' => $row['image']
                    );
                }
            }
        }
   
        return $data;
    }


    // return an array of price info for specified ids;

    public function get_prices($ids)
    {
        global $DataBase;
        $data = array();

        // create a comma separated list of ids
        $items = '';

        foreach ($ids as $id) {
            if ($items != '') {
                $items .= ',';
            }
            $items .= $id;
        }
        // get multiple product info based on list of ids

        $result = $DataBase->query('SELECT id, price From products
         WHERE id IN (' . $items . ')');

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_array()) {

                $data[] = array(
                    'id' => $row['id'],
                    'price' => $row['price']
                );
            }
        }

        return $data;
    }





    // Retrieve product information for all products in specific category

    public function get_in_category($id)
    {
        global $DataBase;


        $data = array();
        $stmt = $DataBase->prepare("SELECT id,name,price,image FROM " . $this->db1_table . " WHERE category_id = ? ");

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($prod_id, $prod_name, $prod_price, $prod_image);

            while ($stmt->fetch()) {
                $data[] = array(
                    'id' => $prod_id,
                    'name' => $prod_name,
                    'price' => $prod_price,
                    'image' => $prod_image
                );
            }
            $stmt->close();
        }
        return $data;
    }


    // -----------------------  Getters *END* -------------------------------









    // -----------------------  Creators *START* -------------------------------

    // create the product table based on category id 

    public function create_product_table($cols = 4, $catID = NULL)
    {

        // get products
        if ($catID != NULL) {
            $products = $this->get_in_category($catID);
        } else {
            $products = $this->get_prod();
        }

        $data = '';

        // loop through each product
        if (!empty($products)) {
            $i = 1;
            foreach ($products as $product) {
                $data .= '<li ';
                if ($i == $cols) {
                    $data .= ' class="last"';
                    $i = 0;
                }
                $data .= '><a href="' . SITE_PATH . 'product.php?id=' . $product['id'] . '">';
                $data .= '<img src="' . IMAGE_PATH . $product['image'] . '" alt="' . $product['name'] . '"><br>';
                $data .= '<strong>' . $product['name'] . '</strong></a><br/>$' . $product['price'];
                $data .= '<br><a class="button_sml" href="' . SITE_PATH . 'cart.php?id=' . $product['id'] . '">Add to cart</a></li>';
                $i++;
            }
        }
        return $data;
    }

    // -----------------------  Creators *END* -------------------------------


    // checks to ensure that product exists


    public function product_exist($id)
    {
        global $DataBase;
        $stmt = $DataBase->prepare('SELECT id FROM products WHERE id = ?');

        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($d);
            $stmt->fetch();

            if ($stmt->num_rows > 0) {
                $stmt->close();
                return true;
            } else {
                return false;
            }
        }
    }
}
