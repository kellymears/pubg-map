<?php

require "config.php";

class map_db {

  var $servername;
  var $username;
  var $password;
  var $conn;

  function __construct($db_servername,$db_username,$db_password) {
    $this->servername = $db_servername;
    $this->username = $db_username;
    $this->password = $db_password;
    $this->connect_to_db();
  }

  function connect_to_db() {
    $this->conn = new_mysqli($this->servername,$this->username,$this->password);
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
    echo "Database connection successful";
  }



}

class map {

 var $db;

 function __construct() {
     $this->db = new map_db($db_servername,$db_username,$db_password)
 }

 function create_poi($name,$type,$lat,$long) {
   $sql = "INSERT INTO map_pois (name, type, lat, long)
          VALUES ($name, $type, $lat, $long)";

   if($this->db->conn->query($sql) === TRUE) {
     echo "New record created successfully";
   } else {
     echo "Error: " . $sql . "<br>" . $this->db->conn->error;
   }
 }

 function read_poi($id) {

 }

 function update_poi($id,$name,$type,$lat,$long) {

 }

 function destroy_poi($id) {

 }

 function retrieve_poi() {

 }

}

?>
