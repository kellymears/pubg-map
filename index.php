<html>
<head>

  <link rel="stylesheet" href="dist/leaflet/leaflet.css"/>
  <link rel="stylesheet" href="app.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="dist/leaflet/leaflet.js"></script>

</head>

<?php require "server.php";
      $squad_pubg = new map($db_servername,$db_username,$db_password,$db_name,$_GET["map"]); ?>

<body>

  <div id="map"></div>

  <script>

  $( document ).ready(function() {

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

    $.ajax({
      method: "GET",
      url: "requests.php",
      data: { request: "readAll", map: "<?php echo $_GET['map']; ?>" }
    })
      .done(function( data ) {
        var json_data = $.parseJSON(data);
        console.log(json_data);
        $.each(json_data, function(key,value) {
          console.log(value.name);
          console.log(parseFloat(value.lat));
          console.log(parseFloat(value.long));
          document["marker" + value.id] = L.marker([parseFloat(value.lat), parseFloat(value.long)]).addTo(map);
          document["marker" + value.id].bindPopup('<b>' + value.name + '</b>').openPopup();
        });
      });
    });

  </script>

</body>
</html>
