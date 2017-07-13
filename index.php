<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mapster</title>
  <link rel="icon" type="image/png" href="images/pubg.png"/>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Foundation Icons -->
  <link rel="stylesheet" href="dist/foundation/icons/foundation-icons.css">

  <!-- Leaflet -->
  <link rel="stylesheet" href="dist/leaflet/leaflet.css"/>

  <!-- Our stylesheet -->
  <link rel="stylesheet" href="app.css" />

</head>

<body>

  <div class="container-fluid">

    <!-- top bar -->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Mapmeister</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">PUBG <span class="sr-only">(current)</span></a></li>
            <!--<li><a href="#">Link</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
          </ul>
          <form class="navbar-form navbar-left">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <!-- <li><a href="#">Link</a></li> -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

    <!-- map -->
    <div id="map"></div>

  </div>

  <!-- jQuery -->
  <script src="dist/jquery-3.2.1.min.js"> </script>

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <!-- Bootstrap select plugin -->
  <script type="text/javascript"
          src="dist/bootstrap-select-1.12.3/js/bootstrap-select.min.js">
  </script>

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
        url = 'http://spacehead.org/images/map-base.jpg';

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
      this._div.innerHTML = '<div class="panel panel-primary">\
                              <div class="panel-heading">\
                                Viewing map: ' + whichMap +'\
                              </div>\
                              <div class="panel-body">\
                                Viewing game: PlayerUnknown\'s Battlegrounds\
                             </div>\
                            </div>';
    };

    info.showNewForm = function (props) {

      this._div.innerHTML += '\
      <div class="panel panel-default">\
        <div class="panel-body">\
          <form id="newMarkerForm">\
            <fieldset>\
              <span class="help-block">Add a new marker:</span>\
              <input id="markerCount" type="hidden"></input>\
              <input id="markerLat" type="hidden"></input>\
              <input id="markerLong" type="hidden"></input>\
              <input id="markerName" type="text" placeholder="Marker Name">\
              <br>\
              <button id="newMarkerSubmit" type="submit" class="btn">Submit</button>\
            </fieldset>\
          </form>\
        </div>\
      </div>';

      $('#markerLat').val(props.latlng.lat);
      $('#markerLong').val(props.latlng.lng);

      /* add new marker */
      $( "#newMarkerForm" ).submit(function( event ) {

        event.preventDefault();

        /* prepare our data */
        markerName = $("#markerName").val();
        markerLat = $("#markerLat").val();
        markerLng = $("#markerLong").val();
        markerType = 0;

        /* submit our data */
        $.ajax({
          method: "POST",
          url: "requests.php",
          data: { request: "create",
                  name: markerName,
                  type: markerType,
                  lat: markerLat,
                  long: markerLng,
                  map: whichMap, }
        })

        /* show the user what we've done */
        .done(function( data ) {

          markerCount = $("#markerCount").val();
          markerName = $("#markerName").val();
          markerLat = $("#markerLat").val();
          markerLng = $("#markerLong").val();
          markerType = 0;
          document["marker_temporary_" + markerCount] =
            L.marker([markerLat,
                      markerLng]).addTo(map);
          document["marker_temporary_" + markerCount].bindPopup('<b>' + markerName + '</b>').openPopup();
        });

      });

    };

    info.addTo(map);

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
            document["marker" + value.id].bindPopup('<b>' + value.name + '</b><br>').openPopup();
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

      map.on('click', onMapClick);

    });

  </script>

</body>
</html>
