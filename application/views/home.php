
<style>
  /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
  #map {
    height: 100%;
  }
  /* Optional: Makes the sample page fill the window. */
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  #description {
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
  }

  #infowindow-content .title {
    font-weight: bold;
  }

  #infowindow-content {
    display: none;
  }

  #map #infowindow-content {
    display: inline;
  }

  .pac-card {
    margin: 10px 10px 0 0;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    background-color: #fff;
    font-family: Roboto;
  }

  #pac-container {
    padding-bottom: 12px;
    margin-right: 12px;
  }

  .pac-controls {
    display: inline-block;
    padding: 5px 11px;
  }

  .pac-controls label {
    font-family: Roboto;
    font-size: 13px;
    font-weight: 300;
  }

  #pac-input {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 400px;
  }

  #pac-input:focus {
    border-color: #4d90fe;
  }

  #title {
    color: #fff;
    background-color: #4d90fe;
    font-size: 25px;
    font-weight: 500;
    padding: 6px 12px;
  }
  #target {
    width: 345px;
  }
</style>
   <div class="container">
	<input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map" style="height:600px;"></div>
    <script>
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 14.5995124, lng: 120.9842195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });        

        var schools = [
        	["UST", 14.6096767, 120.9896407],
        	["NU", 14.6042605, 120.9943511],
        	["FEU", 14.6038621, 120.9864347],
        	["UE", 14.602027, 14.602027],
        	["AU", 14.599903, 120.9964732]
        ];

        var dormsMarker = new Array();
        var dorms = <?php echo json_encode($dorms); ?>;
        
        for(var i=0;i<4;i++){
          dormsMarker.push([dorms[i]['name'], dorms[i]['latitude'], dorms[i]['longitude']]);
        }

        var infowindow = new google.maps.InfoWindow();
            //var schimg = "https://cdn.vectorstock.com/i/1000x1000/04/69/school-map-pointer-icon-marker-gps-location-flag-vector-15450469.jpg";
    		var marker, i;

    		var schimg = {
    			url: "https://cdn1.iconfinder.com/data/icons/real-estate-set-3/512/3-512.png",
    			// This marker is 20 pixels wide by 32 pixels high.
    			size: new google.maps.Size(20, 32)
    		};

        // marker for schools
    		for (i = 0; i < dormsMarker.length; i++) {  
    		  marker = new google.maps.Marker({
    		    position: new google.maps.LatLng(dormsMarker[i][1], dormsMarker[i][2]),
    		    map: map
    		    //icon: schimg
    		  });

    		  google.maps.event.addListener(marker, 'click', (function(marker, i) {
    		    return function() {
    		      infowindow.setContent(dormsMarker[i][0]);
    		      infowindow.open(map, marker);
    		    }
    		  })(marker, i));
    		}

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYAHflaAbuCFeWhrIv5CUzuj1w3dEFjAM&libraries=places&callback=initAutocomplete"
         async defer></script>
</div>