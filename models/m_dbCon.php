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
 
    if ($DataBase) {
      print('<script>console.log("connection with DB was successful");</script>');
    } else {
      echo ("<script>console.log('connection Failed ');</script>");
    }
   }
  }
?>