<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mapster</title>
  <link rel="icon" type="image/png" href="images/pubg.png"/>

  <!-- jQuery -->
  <script type="text/javascript" src="dist/jquery-3.2.1.min.js"> </script>

  <!-- Bootstrap -->
  <link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

  <!-- Bootstrap select plugin -->
  <script type="text/javascript"
          src="dist/bootstrap-select-1.12.3/js/bootstrap-select.min.js">
  </script>


  <!-- Foundation Icons -->
  <link rel="stylesheet" href="dist/foundation/icons/foundation-icons.css">

  <!-- Leaflet -->
  <link rel="stylesheet" href="dist/leaflet/leaflet.css"/>

  <!-- Our stylesheet -->
  <link rel="stylesheet" href="app.css" />

</head>

<body>

  <!-- top bar -->
  <div class="navbar" style="margin-bottom:0em;">
  <div class="navbar-inner">
    <a class="brand" href="#">Mapster</a>
    <ul class="nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Link</a></li>
      <li><a href="#">Link</a></li>
    </ul>
  </div>
</div>

  <!-- map -->
  <div id="map"></div>

  <!-- bootstrap js -->
  <script src="dist/bootstrap/js/bootstrap.js"></script>

  <!-- jquery -->
  <script src="dist/foundation/js/vendor/jquery.js"></script>

  <!-- leaflet js -->
  <script src="dist/leaflet/leaflet.js"></script>

  <script>

  $( document ).ready(function() {

    var whichMap = "<?php if(isset($_GET['map'])) { echo $_GET['map']; } ?>";
    if (!whichMap) {
      whichMap = "default";
    }

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

    /* map info */

    var info = L.control();

    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
        L.DomEvent.disableClickPropagation(this._div);
        this.update();
        return this._div;
    };

    info.update = function (props) {
        this._div.innerHTML = '<h4>Player Unknown\'s Battlegrounds</h4> \
                                <b>Viewing map:</b> ' + whichMap;
        if(props) {
          this._div.innerHTML += "<p>Map clicked at "+ props.latlng +"</p>";
        }
    };

    info.showNewForm = function (props) {
      console.log(props);
      this._div.innerHTML += '\
      <form>\
        <fieldset>\
          <span class="help-block">Add a new marker:</span>\
          <input type="text" placeholder="Marker Name">\
          <br>\
          <button type="submit" class="btn">Submit</button>\
        </fieldset>\
        </form>';
      this._div.innerHTML += "<p>Adding point at "+ props.latlng +"</p>";
    };

    $( "#newMarkerSubmit" ).submit(function( event ) {
      console.log( "Handler for .submit() called." );
      event.preventDefault();
    });

    info.addTo(map);

    /* add new marker */

    $.ajax({

    });

    /* display markers */

    $.ajax({
      method: "POST",
      url: "requests.php",
      data: { request: "readAll", map: whichMap }
    })
      .done(function( data ) {
        if (data) {
          var json_data = JSON.parse(data);
          $.each(json_data, function(key,value) {
            document["marker" + value.id] =
              L.marker([parseFloat(value.lat),
                        parseFloat(value.long)]).addTo(map);
            document["marker" + value.id].bindPopup('<b>' + value.name + '</b>').openPopup();
          });
        }
      });

      /* on click interactivity */

      var popup = L.popup();

      function onMapClick(e) {
          popup
              .setLatLng(e.latlng)
              .setContent("<a id='addNew' href='#'>Add Marker</a>")
              .openOn(map);
         info.update(e);
         console.log('map clicked');

         // Assign the javascript obj to another variable to not get overriden
         var mapClickObj = e;

         $('#addNew').click(function(e){
           info.showNewForm(mapClickObj);
         });
      }

      function onMapAdd(coord) {
        console.log(coord);
        info.showNewForm(coord);
      }

      map.on('click', onMapClick);

    });

  </script>

</body>
</html>
