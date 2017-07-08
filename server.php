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
      $result = $this->conn->query($sql);
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
   return $result = $this->db->call_query($sql, "Reading POI successful");
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

 function display_pois() {
   $sql = "SELECT * FROM `map_pois`";
   $result = $this->db->call_query($sql, "Display POI query successful");
   while ($row = $result->fetch_assoc()) {
     $result_array[$row['id']]['id'] = $row['id'];
     $result_array[$row['id']]['name'] = $row['name'];
     $result_array[$row['id']]['type'] = $row['type'];
     $result_array[$row['id']]['lat'] = $row['lat'];
     $result_array[$row['id']]['long'] = $row['long'];
   }
   return $result_array;
 }

}

?>
