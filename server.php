<?php

require "config.php";

class map_db {

  private $name;
  private $servername;
  private $username;
  private $password;
  private $conn;

  public $log;

  function __construct($db_servername,$db_username,$db_password,$db_name) {
    $this->servername = $db_servername;
    $this->username = $db_username;
    $this->password = $db_password;
    $this->name = $db_name;
    $this->connect_to_db();
  }

  function connect_to_db() {
    $this->conn = new mysqli($this->servername,$this->username,$this->password,$this->name);
    if ($this->conn->connect_error) {
      $this->log[] = "Connection failed: " . $this->db->conn->connect_error;
    } else {
      $this->log[] = "Database connection successful";
    }
  }

  function call_query($sql, $msg) {
    if($this->conn->query($sql)) {
      
      $result = $this->conn->query($sql)->fetch_assoc();
      $this->log[] = $msg;
      $this->log[] = $result;

      return $result;

    } else {
     $this->log[] = "Error: " . $sql . " resulted in " . $this->db->conn->error;
    }
  }

}

class map {

  public $db;
  public $pois;

  function __construct($db_servername,$db_username,$db_password,$db_name) {
    $this->db = new map_db($db_servername,$db_username,$db_password,$db_name);
  }

 function create_poi($name,$type,$lat,$long) {
   $sql = "INSERT INTO `map_pois` (name, type, lat, long)
          VALUES ($name, $type, $lat, $long)";
   $this->db->call_query($sql, "New record created successfully");
 }

 function read_poi($id) {
   $sql = "SELECT * FROM `map_pois` WHERE `id`='".$id."'";
   $result = $this->db->call_query($sql, "Reading POI successful");
   // TODO something with the result
   // while ($row = $result->fetch_assoc())
 }

 function update_poi($id,$name,$type,$lat,$long) {
   $sql = "UPDATE `map_pois` SET `name`='".$name."', `type`='".$type."',
           `lat`='".$lat."', `long`='".$long."' WHERE `id`='".$id."'";
   $result = $this->db->call_query($sql, "Record updated successfully");
 }

 function destroy_poi($id) {
   $sql = "DELETE FROM `map_pois` WHERE `id`='".$id."'";
   $result = $this->db->call_query($sql, "POI record deleted successfully");
 }

}

?>
