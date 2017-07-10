<html>
<head>

  <link rel="stylesheet" href="dist/leaflet/leaflet.css"/>
  <script src="dist/leaflet/leaflet.js"></script>

  <style>
  #map {
    min-height:100%;
    min-width:100%;
  }

  .info {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white;
    background: rgba(255,255,255,0.8);
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    border-radius: 5px;
}
.info h4 {
    margin: 0 0 5px;
    color: #777;
}

.legend {
    line-height: 18px;
    color: #555;
}
.legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
}

  </style>

</head>

<?php require "server.php";
      $squad_pubg = new map($db_servername,$db_username,$db_password,$db_name,$_GET["map"]); ?>

<body>

  <div id="map"></div>

  <script>

    var map = L.map('map', {
      minZoom: 1,
      maxZoom: 4,
      center: [0, 0],
      zoom: 1,
      crs: L.CRS.Simple
    });

    // dimensions of the image
    var w = 5184,
        h = 5184,
        url = 'images/map-base.jpg';

    // calculate the edges of the image, in coordinate space
    var southWest = map.unproject([0, h], map.getMaxZoom()-1);
    var northEast = map.unproject([w, 0], map.getMaxZoom()-1);
    var bounds = new L.LatLngBounds(southWest, northEast);

    // add the image overlay,
    // so that it covers the entire map
    L.imageOverlay(url, bounds).addTo(map);

    // tell leaflet that the map is exactly as big as the image
    map.setMaxBounds(bounds);

    var popup = L.popup();

    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString() + "<br><a href='requests.php?request=create&name=Test&type=1&lat="+ e.latlng.lat +"&long="+ e.latlng.lng +"&map=<?php echo $_GET['map']; ?>'>Test</a>")
            .openOn(map);
    }

    map.on('click', onMapClick);

    var info = L.control();

    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
        this.update();
        return this._div;
    };

    // method that we will use to update the control based on feature properties passed
    info.update = function (props) {
        this._div.innerHTML = '<h4>Player Unknown\'s Battlegrounds</h4>' +  (props ?
            '<b>' + props.name + '</b><br />' + props.density + ' people / mi<sup>2</sup>'
            : '<b>Viewing map:</b> <?php echo $_GET['map']; ?>');
    };

    info.addTo(map);

    <?php

        /* display POIs */

        $pois = $squad_pubg->display_pois();

        foreach($pois as $poi) {
          echo "var marker_". $poi['id'] ." = L.marker([". $poi['lat'] .", ". $poi['long'] ."]).addTo(map);\n
                marker_". $poi['id'] .".bindPopup('<b>". $poi['name'] ."</b>').openPopup();";
        }

    ?>

  </script>

</body>
</html>
