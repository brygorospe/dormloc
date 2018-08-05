
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
    width:20%;
  }

  .filter-field {
    overflow:hidden;
  }

  .filter-field div{
    float:left;
    width:20%;
  }

  .pointer {
    cursor: pointer;
  }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <div class="container" style="float:left;width:300px;height:700px;overflow-y:scroll;margin-top:50px;padding-top:10px;">
    <!--h2>Panel Group</h2>
    <p>The panel-group class clears the bottom-margin. Try to remove the class and see what happens.</p-->
    <div class="panel-group" id="panel-group">
      <!--div class="panel panel-default" onclick="newLocation(14.5995124, 120.9842195);">
        <div class="panel-heading">Panel Header</div>
        <div class="panel-body">Panel Content</div>
      </div-->
    </div>
  </div>

   <div class="container" style="padding-left:150px;">
      <div class="div-filter">
        <form action="" method="POST">
          <div class="filter-label">
            <div>
              Price Range:
            </div>
            <div>
              Filter Type:
            </div>
            <div>
              Room Sharing:
            </div>
            <div>
              Room Availability:
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
              <select id="filter_type" name="filter_type">
                <option value="">All</option>
                <option value="CONDO">Condo</option>
                <option value="APARTMENT">Apartment</option>
                <option value="DORM">Dorm</option>
              </select>
            </div>
            <div>
              <select id="filter_sharing" name="filter_sharing">
                <option value="">All</option>
                <option value="1">Yes</option>
                <option value="FALSE">No</option>
              </select>
            </div>
            <div>
              <select id="filter_availability" name="filter_availability">
                <option value="">All</option>
                <option value="1">Yes</option>
                <option value="FALSE">No</option>
              </select>
            </div>
            <div>
              Pool&nbsp<input type="checkbox" name="filter_amenities[]" id="filter_amenities_pool" value="Pool">
              Wifi&nbsp<input type="checkbox" name="filter_amenities[]" id="filter_amenities_wifi" value="Wifi">
              Event Room&nbsp<input type="checkbox" name="filter_amenities[]" id="filter_amenities_eventroom" value="Event Room">
              Canteen&nbsp<input type="checkbox" name="filter_amenities[]" id="filter_amenities_canteen" value="Canteen">
              Study Area&nbsp<input type="checkbox" name="filter_amenities[]" id="filter_amenities_studyarea" value="Study Area">
              Others: <input type="text" name="filter_amenities_others" id="filter_amenities_others" style="max-width:100px;">
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
        var map;
        var marker, markers = new Array();

        function newLocation(newLat, newLng, i)
        {
          map.setCenter({
            lat : newLat,
            lng : newLng
          });
          console.log(marker);
          google.maps.event.trigger(markers[i], 'click');
        }

        function initAutocomplete() {
           map = new google.maps.Map(document.getElementById('map'), {
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
          
          var filter_price = <?php echo json_encode($filter_price); ?>;
          var filter_sharing = <?php echo json_encode($filter_sharing); ?>;
          var filter_availability = <?php echo json_encode($filter_availability); ?>;
          var filter_type = <?php echo json_encode($filter_type); ?>;
          var filter_amenities = <?php echo json_encode($filter_amenities); ?>;
          var filter_amenities_others = <?php echo json_encode($filter_amenities_others); ?>;
          var if_sharing = null;
          var if_available = null;
          var if_amenities = "";
          document.getElementById('filter_price').value = filter_price;
          document.getElementById('filter_sharing').value = filter_sharing;
          document.getElementById('filter_type').value = filter_type;
          document.getElementById('filter_availability').value = filter_availability;
          document.getElementById('filter_amenities_others').value = filter_amenities_others;
          if (filter_amenities) {
            for (i = 0; i < filter_amenities.length; i++) { 
              var id = 'filter_amenities_'+filter_amenities[i].replace(/\s/g, '').toLowerCase();
              document.getElementById(id).checked = 1;
            }
          }

          for(var i=0;i<dorms.length;i++){
            /*if (filter_price){
              if (filter_sharing) {
                if (dorms[i]['rate'] <= filter_price 
                  && dorms[i]['rate'] > filter_price-1000 
                  && dorms[i]['isSharing'] != filter_sharing 
                  && dorms[i]['room_availability'] != if_available 
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
                          dorms[i]['room_details'],
                          dorms[i]['type'],
                          dorms[i]['room_availability']]);
                }
              } else {
                if (dorms[i]['rate'] <= filter_price 
                  && dorms[i]['rate'] > filter_price-1000 
                  && dorms[i]['room_availability'] != if_available 
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
                          dorms[i]['room_details'],
                          dorms[i]['type'],
                          dorms[i]['room_availability']]);
                }
              }
            } else {
              if (filter_amenities || filter_availability) {
                if (filter_sharing) {
                  if (dorms[i]['isSharing'] != filter_sharing
                    && dorms[i]['room_availability'] != if_available 
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
                            dorms[i]['room_details'],
                            dorms[i]['type'],
                            dorms[i]['room_availability']]);  
                  }
                } else {
                  if (dorms[i]['room_availability'] != if_available 
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
                            dorms[i]['room_details'],
                            dorms[i]['type'],
                            dorms[i]['room_availability']]);  
                  }
                }
                
              } else {
                if (filter_sharing) {
                  if (dorms[i]['room_availability'] != if_available) {
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
                              dorms[i]['room_details'],
                              dorms[i]['type'],
                              dorms[i]['room_availability']]);  
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
                              dorms[i]['room_details'],
                              dorms[i]['type'],
                              dorms[i]['room_availability']]);
                }
              }
            }*/
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
                              dorms[i]['room_details'],
                              dorms[i]['type'],
                              dorms[i]['room_availability'],
                              dorms[i]['created_by']]);
          }

          var infowindow = new google.maps.InfoWindow();
              //var schimg = "https://cdn.vectorstock.com/i/1000x1000/04/69/school-map-pointer-icon-marker-gps-location-flag-vector-15450469.jpg";
      		var i;

      		var schimg = {
      			url: "https://cdn1.iconfinder.com/data/icons/real-estate-set-3/512/3-512.png",
      			// This marker is 20 pixels wide by 32 pixels high.
      			size: new google.maps.Size(20, 32)
      		};

          var div = document.getElementById('panel-group');
          
          // marker for schools
      		for (i = 0; i < dormsMarker.length; i++) {  
      		  marker = new google.maps.Marker({
      		    position: new google.maps.LatLng(dormsMarker[i][1], dormsMarker[i][2]),
      		    map: map
      		    //icon: schimg
      		  });
            markers.push(marker);
            div.innerHTML += '<div class="panel panel-primary pointer" onclick="newLocation('+dormsMarker[i][1]+','+dormsMarker[i][2]+','+i+');"><div class="panel-heading">'+dormsMarker[i][0]+'</div><div class="panel-body">'+dormsMarker[i][3]+'</div></div>';

            
      		  google.maps.event.addListener(marker, 'click', (function(marker, i) {
      		    return function() {
                var rate = dormsMarker[i][3];
                if (rate) {
                  rate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                infowindow.setContent('<div id="content">'+
                                        '<img src="../uploads/'+dormsMarker[i][14]+'/'+dormsMarker[i][14]+'.jpg'+'" width="50px;" height="50px;" />'+
                                        '<h4 style="font-weight:bold">'+dormsMarker[i][0]+'</h4>'+
                                        '<div id="bodyContent">'+
                                          //'<b>Room Size:</b> '+dormsMarker[i][5]+'<br/>'+
                                          '<b>Rate:</b> '+rate+'<br/>'+
                                          '<br/><p><a href="#ex1" rel="modal:open">See more details</a></p>'+
                                          '<div id="ex1" class="modal" style="top:50px;left:500px;">'+
                                            '<div class="modal-header">'+
                                              '<h4 class="modal-title">'+dormsMarker[i][0]+'</h4>'+
                                            '</div>'+
                                            '<div class="modal-body">'+
                                              //'<b>Room Size:</b> '+dormsMarker[i][5]+'<br/>'+
                                              '<b>Rate:</b> '+rate+'<br/>'+
                                              '<b>Type:</b> '+dormsMarker[i][12]+'<br/>'+
                                              '<b>Room Sharing:</b> '+(dormsMarker[i][4] == true ? "Yes" : "No")+'<br/>'+
                                              '<b>Room Available:</b> '+(dormsMarker[i][13] == true ? "Yes" : "No")+'<br/>'+
                                              '<b>Room Details:</b> '+dormsMarker[i][11]+'<br/>'+
                                              '<b>Amenities:</b> '+dormsMarker[i][6]+'<br/>'+
                                              '<b>Policies:</b> '+dormsMarker[i][7]+'<br/>'+
                                              '<b>Contact Number:</b> '+dormsMarker[i][8]+'<br/>'+
                                              '<b>Contact Name:</b> '+dormsMarker[i][9]+'<br/>'+
                                              '<b>Photo:</b><br/>'+
                                              '<img src="../uploads/'+dormsMarker[i][10]+'/'+dormsMarker[i][10]+'.jpg'+'" />'+
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