<?php

  class DB

{

  private $DataBase;
   //connect to the Db

   public function __construct() {
    global $DataBase;
    $server =  "localhost";
    $dbUserName = "root";
    $dbPassword = "";
    $dbName = "fox";
    $DataBase = $this->DataBase;

   
    $DataBase = new mysqli($server, $dbUserName, $dbPassword, $dbName);
 
   
   }
  }
?>