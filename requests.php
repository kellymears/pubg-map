<?php

  require "server.php";
  $squad_pubg = new map($db_servername,$db_username,$db_password,$db_name,$_GET["map"]);

  if($_GET['map']) {

    if($_GET['request']=="add") {
      $squad_pubg->create_poi($_GET['name'],$_GET['type'],$_GET['lat'],$_GET['long'],$_GET['map']);
    }

  }

?>
