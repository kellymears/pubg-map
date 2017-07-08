<?php

require "config.php";

class map_db {

  private $servername;
  private $username;
  private $password;
  private $conn;

  function __construct($db_servername,$db_username,$db_password) {
    $this->servername = $db_servername;
    $this->username = $db_username;
    $this->password = $db_password;
    $this->connect_to_db();
  }

  function connect_to_db() {
    $this->conn = new mysqli($this->servername,$this->username,$this->password);
    echo "Database connection successful";
  }

}

class map {

  private $db;

  public $log;
  public $pois;

  function __construct() {
      $this->db = new map_db($db_servername,$db_username,$db_password);
      if ($this->db->conn->connect_error) {
        $this->log[] = "Connection failed: " . $this->db->conn->connect_error;
      } else {
        $this->log[] = "Database connection successful";
      }
  }

  function call_query($sql, $msg, $fetch=False) {
    if($this->db->conn->query($sql) === TRUE) {
      $this->log[] = $msg;
      if $fetch {
       return $this->db->conn->query($sql)->fetch_assoc();
      } else {
       $this->log[] = "Error: " . $sql . "<br>" . $this->db->conn->error;
      }
   }
 }

 function create_poi($name,$type,$lat,$long) {
   $sql = "INSERT INTO `map_pois` (name, type, lat, long)
          VALUES ($name, $type, $lat, $long)";

   $this->call_query($sql, "New record created successfully");
 }

 function read_poi($id) {
   $sql = "SELECT * FROM `map_pois` WHERE `id`='".$id."'";

   $result = $this->call_query($sql, "Reading POI successful");

   // TODO something with the result
   // while ($row = $result->fetch_assoc())
 }

 function update_poi($id,$name,$type,$lat,$long) {
   $sql = "UPDATE `map_pois` SET `name`='".$name."', `type`='".$type."',
           `lat`='".$lat."', `long`='".$long."' WHERE `id`='".$id."'";
   $this->call_query($sql, "Record updated successfully");
 }

 function destroy_poi($id) {
   $sql = "DELETE FROM `map_pois` WHERE `id`='".$id."'";

   $this->call_query($sql, "POI record deleted successfully");
 }

 function retrieve_poi() {

 }

}

?>
