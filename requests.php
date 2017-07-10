<?php

  require "server.php";
  $squad_pubg = new map($db_servername,$db_username,$db_password,$db_name,$_GET["map"]);

  if($_GET['map']) {

    if($_GET['request']=="create") {
      $result = $squad_pubg->create_poi($_GET['name'],$_GET['type'],$_GET['lat'],$_GET['long'],$_GET['map']);
      echo $result;
    }

    /* if($_GET['request']=="update") {
      $result = $squad_pubg->update_poi($_GET['id'],$_GET['name'],$_GET['type'],$_GET['lat'],$_GET['long'],$_GET['map']);
    }

    if($_GET['request']=="delete") {
      $result = $squad_pubg->destroy_poi($_GET['id']);
    }

    if($_GET['request']=="read") {
      $result = $squad_pubg->read_poi($_GET['id']);
    } */

    if($_GET['request']=="readAll") {
      $result = $squad_pubg->display_pois();
    }

    if ($result) {
        echo json_encode($result);
    }

  }

?>
