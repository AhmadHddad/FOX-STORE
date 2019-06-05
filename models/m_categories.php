 <?php


    class Categories
    {
        public $db_table = 'categories';


        public function __construct()
        { }


        // -----------------------  Getters *START* -------------------------------


        // getting categories from DB by query either by specific id or all categories 

        public function get_categories($id = null)
        {
            global $DataBase;

            $data = array();
            if ($id != null) {

                // get specific category
                $stmt = $DataBase->prepare("SELECT `id`, `name` FROM categories WHERE `id` = ? LIMIT 1");
                if ($stmt) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->store_result();

                    $stmt->bind_result($cat_id, $cat_name);
                    $stmt->fetch();

                    if ($stmt->num_rows > 0) {
                        $data = array('id' => $cat_id, 'name' => $cat_name);
                    }
                    $stmt->close();
                    
                }
            } else {
                // get all categories
                if ($result =  $DataBase->query("SELECT * FROM " . $this->db_table . " ORDER BY name")) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array()) {
                            $data[] = array('id' => $row['id'], 'name' => $row['name']);
                        }
                    }
                }
            }



            return $data;
        }


        // -----------------------  Getters *END* -------------------------------



        // -----------------------  Creators *START* -------------------------------


        // Creating navigation bar by taking the data from get_categories and displaying it 

        public function create_category_nav($active = NULL)
        {
            // get all categories
            $categories = $this->get_categories();

            // set up 'all' item
            $data = '<li';
            if ($active == strtolower('home')) {
                $data .= ' class="active"';
            }
            $data .= '><a href="' . SITE_PATH . '">View All</a></li>';

            // loop through each category
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    $data .= '<li ';
                    if (strtolower($active) == strtolower($category['name'])) {
                        $data .= ' class="active"';
                    }

                    $data .= '><a href="' . SITE_PATH . 'index.php?id=' . $category['id'] . '">' . $category['name'] . '</a></li>';
                }
            }

            return $data;
        }

        // -----------------------  Creators *END* -------------------------------


    }
