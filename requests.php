<?php

  require "server.php";
  $squad_pubg = new map($db_servername,$db_username,$db_password,$db_name,$_POST["map"]);

  if($_POST['map']) {

    if($_POST['request']=="create") {
      $result = $squad_pubg->create_poi($_POST['name'],$_POST['type'],$_POST['lat'],$_POST['long'],$_POST['map']);
      echo $result;
    }

    /* if($_POST['request']=="update") {
      $result = $squad_pubg->update_poi($_POST['id'],$_POST['name'],$_POST['type'],$_POST['lat'],$_POST['long'],$_POST['map']);
    }

    if($_POST['request']=="delete") {
      $result = $squad_pubg->destroy_poi($_POST['id']);
    }

    if($_POST['request']=="read") {
      $result = $squad_pubg->read_poi($_POST['id']);
    } */

    if($_POST['request']=="readAll") {
      $result = $squad_pubg->display_pois();
    }

    if ($result) {
        echo json_encode($result);
    }

  }

?>
