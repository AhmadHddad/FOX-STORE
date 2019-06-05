<?php
/*
class Products
{
    private $db_table = 'products';

    public function __construct()
    {
    }


    public function get($id = null)
    {
        global $DataBase;
    
        print_r($DataBase);

        $data = array();

        if (is_array($id)) {
            // get the products based on $data
        } elseif ($id != null) {
            $stmt = $DataBase->prepare("SELECT 
        $this->db_table.id,
        $this->db_table.name,
        $this->db_table.description,
        $this->db_table.price,
        $this->db_table.image,
        category.name AS category_name
         FROM db_table, categories
         WHERE db_table.id = ? AND db_table.category_id = catagories.id");

            if ($stmt) {
                $stmt->bind.param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($prod_id, $prod_name, $prod_description, $prod_price, $prod_image, $cat_name);
                $stmt->fetch();


                if ($stmt->num_rows > 0) {
                    $data =  array('id' => $prod_id , 'name' => $prod_name , 'description' => $prod_description , 'price'=> $prod_price , 'image'=>$prod_image, 'category_name'=>$cat_name);
                }
                $stmt->close();
            }
        }

        return $data;
    }
} */


class Products
{
    private $db_table = 'products';

    public function __construct()
    {

        global $DataBase;
        $stmt = $DataBase->query("SELECT `id` FROM `products` AS CAT_ID");

        print_r($stmt);
        return $stmt;

    }


    public function get($id = null)
    {
        global $DataBase;
    
        

        $data = array();

        if (is_array($id)) {
            // get the products based on $data
        } elseif ($id != null) {
            $stmt = $DataBase->prepare("SELECT id,`name` AS CAT_NAME,description,price,image 
            FROM `products`,  WHERE `id` = ?   ");
        

            if ($stmt) {
                 $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($prod_id,$prod_name,$prod_description,$prod_price,$prod_image);
                $stmt->fetch();


                if ($stmt->num_rows > 0) {
                    $data =  array('id' => $prod_id , 'name'=>$prod_name,'description'=>$prod_description,'price'=>$prod_price,'image'=>$prod_image);
                }
                $stmt->close();
            }
        }

        return $data;
    }
}