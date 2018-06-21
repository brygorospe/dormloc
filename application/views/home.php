
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

  .modal a.close-modal{
    display:none!important;
  }

  .div-filter {
    padding:5px;
  }

  .div-filter div {
    padding:2px;
  }

  .filter-label {
    overflow:hidden;
  }

  .filter-label div{
    float:left;
    width:30%;
  }

  .filter-field {
    overflow:hidden;
  }

  .filter-field div{
    float:left;
    width:30%;
  }

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

   <div class="container">
      <div class="div-filter">
        <form action="" method="get">
          <div class="filter-label">
            <div>
              Price Range:
            </div>
            <div>
              Room Sharing:
            </div>
            <div>
              Amenities:
            </div>
          </div>
          <div class=filter-field>
            <div>
              <select id="filter_price" name="filter_price">
                <option value="">All</option>
                <option value="1000">1,000 and below</option>
                <option value="2000">1,001 > 2,000</option>
                <option value="3000">2,001 > 3,000</option>
                <option value="4000">3,001 > 4,000</option>
                <option value="5000">4,001 > 5,000</option>
                <option value="6000">5,001 and above</option>
              </select>
            </div>
            <div>
              <input type="checkbox" name="filter_sharing" id="filter_sharing">
            </div>
            <div>
              <input type="text" name="filter_amenities" id="filter_amenities">
            </div>
          </div>
          <div>
            <input type="submit" value="Filter">
          </div>
        </form>
      </div>
      
      <input id="pac-input" class="controls" type="text" placeholder="Search Box">
      <div id="map" style="height:500px;"></div>
      
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
            zoom: 15,
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
          
          var getUrlParameter  = function getUrlParameter(sParam) {
              var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                  sURLVariables = sPageURL.split('&'),
                  sParameterName,
                  i;

              for (i = 0; i < sURLVariables.length; i++) {
                  sParameterName = sURLVariables[i].split('=');

                  if (sParameterName[0] === sParam) {
                      return sParameterName[1] === undefined ? true : sParameterName[1];
                  }
              }
          };
          
          var filter_price = getUrlParameter('filter_price');
          var filter_sharing = getUrlParameter('filter_sharing');
          var filter_amenities = getUrlParameter('filter_amenities');
          var if_sharing = null;
          var if_amenities = "";
          document.getElementById('filter_price').value = filter_price;
          if (filter_sharing) {
            document.getElementById('filter_sharing').checked = 1;
            if_sharing = 0;
          }
          if (filter_amenities) {
            document.getElementById('filter_amenities').value = filter_amenities.replace("+", " ");
            if_amenities = filter_amenities;
          }

          for(var i=0;i<dorms.length;i++){
            if (filter_price){
              if (dorms[i]['rate'] <= filter_price 
                  && dorms[i]['rate'] > filter_price-1000 
                  && dorms[i]['isSharing'] != if_sharing 
                  && dorms[i]['amenities'].includes(if_amenities.replace("+", " "))) {
                dormsMarker.push([dorms[i]['name'], 
                          dorms[i]['latitude'], 
                          dorms[i]['longitude'],
                          dorms[i]['rate'],
                          dorms[i]['isSharing'],
                          dorms[i]['size'],
                          dorms[i]['amenities'],
                          dorms[i]['policy'],
                          dorms[i]['contact_no'],
                          dorms[i]['contact_name'],
                          dorms[i]['id'],
                          dorms[i]['room_details']]);  
              }
            } else {
              if (filter_sharing || filter_amenities) {
                if (dorms[i]['isSharing'] != if_sharing && dorms[i]['amenities'].includes(if_amenities.replace("+", " "))) {
                  dormsMarker.push([dorms[i]['name'], 
                          dorms[i]['latitude'], 
                          dorms[i]['longitude'],
                          dorms[i]['rate'],
                          dorms[i]['isSharing'],
                          dorms[i]['size'],
                          dorms[i]['amenities'],
                          dorms[i]['policy'],
                          dorms[i]['contact_no'],
                          dorms[i]['contact_name'],
                          dorms[i]['id'],
                          dorms[i]['room_details']]);  
                }
              } else {
                dormsMarker.push([dorms[i]['name'], 
                              dorms[i]['latitude'], 
                              dorms[i]['longitude'],
                              dorms[i]['rate'],
                              dorms[i]['isSharing'],
                              dorms[i]['size'],
                              dorms[i]['amenities'],
                              dorms[i]['policy'],
                              dorms[i]['contact_no'],
                              dorms[i]['contact_name'],
                              dorms[i]['id'],
                              dorms[i]['room_details']]);
              }
            }
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
                var rate = dormsMarker[i][3];
                if (rate) {
                  rate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                }
      		      infowindow.setContent('<div id="content">'+
                                        '<h4 style="font-weight:bold">'+dormsMarker[i][0]+'</h4>'+
                                        '<div id="bodyContent">'+
                                          '<b>Room Size:</b> '+dormsMarker[i][5]+'<br/>'+
                                          '<b>Rate:</b> '+rate+'<br/>'+
                                          '<br/><p><a href="#ex1" rel="modal:open">See more details</a></p>'+
                                          '<div id="ex1" class="modal">'+
                                            '<div class="modal-header">'+
                                              '<h4 class="modal-title">'+dormsMarker[i][0]+'</h4>'+
                                            '</div>'+
                                            '<div class="modal-body">'+
                                              '<b>Room Size:</b> '+dormsMarker[i][5]+'<br/>'+
                                              '<b>Rate:</b> '+rate+'<br/>'+
                                              '<b>Room Sharing:</b> '+(dormsMarker[i][4] == true ? "Yes" : "No")+'<br/>'+
                                              '<b>Room Details:</b> '+dormsMarker[i][11]+'<br/>'+
                                              '<b>Amenities:</b> '+dormsMarker[i][6]+'<br/>'+
                                              '<b>Policies:</b> '+dormsMarker[i][7]+'<br/>'+
                                              '<b>Contact Number:</b> '+dormsMarker[i][8]+'<br/>'+
                                              '<b>Contact Name:</b> '+dormsMarker[i][9]+'<br/>'+
                                            '</div>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>');
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
</div>