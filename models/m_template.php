<?php
// Template Class
// Handling all template tasks - displaying views, alerts, errors and view data

class Template
{
    public $data;
    public $alert_types = array("success", "alert", "error");

    public function __construct()
    { }

    // -----------------------  Modifiers *START* -------------------------------


    /**
     * loads specified URL
     * @param string
     * @return null
     **/
    public function load($url, $title = "")
    {
        if ($title != '') {
            $this->set_data("Page Title", $title);
        }
        include($url);
    }

    /**
     * redirect to specified URL
     *
     * @param sting $var Description
     * @return null
     **/

    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    // -----------------------  Modifiers *END* -------------------------------








    // -----------------------  Getters & Setters *START* -------------------------------


    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/


    public function get_data($name, $echo = true)
    {
        if (isset($this->data[$name])) {
            if ($echo) {
                echo $this->data[$name];
            } else {
                return $this->data[$name];
            }
        }
        return '';
    }


    public function getAllData()
    {
        return $this->data;
    }



    // get the alert from set alert
    public function get_alert()
    {
        $data = '';

        foreach ($this->alert_types as $alerts) {
            if (isset($_SESSION[$alerts])) {
                foreach ($_SESSION[$alerts] as $value) {
                    $data .= '<li class="' . $alerts . '">'  . $value . '</li>';
                }
            }
            unset($_SESSION[$alerts]);
        }
        echo $data;
    }






    // -----------------------  Setters -------------------------------


    /**
     * Set an alert message stored in the session variable
     *
     * @param string
     * @return null
     **/
    public function set_alert($error_message, $S_variable = "success")
    {
        $_SESSION[$S_variable][] = $error_message;
    }

    /**
     * get / set data
     *
     * @param sting,string,boolean
     * @return null
     **/


    public function set_data($name, $value, $clean = false)
    {
        if ($clean) {
            $this->data[$name] = htmlentities($value, ENT_QUOTES);
        } else {
            $this->data[$name] = $value;
        }
    }




    // -----------------------  Getters & Setters *END* -------------------------------
}
