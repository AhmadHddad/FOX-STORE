<?php 


    if (!isset($_SESSION['username'])) {
   
        $template->set_alert('You must log-in first to use this feature',"error");
    }
