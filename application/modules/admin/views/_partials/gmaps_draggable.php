<div id="map" style="height:500px;"></div>
<script>
	function initMap() {
		var myLatlng = new google.maps.LatLng(document.getElementById("field-latitude").value, document.getElementById("field-longitude").value);
		var mapOptions = {
		  zoom: 15,
		  center: myLatlng
		}
		var map = new google.maps.Map(document.getElementById("map"), mapOptions);

		// Place a draggable marker on the map
		var marker = new google.maps.Marker({
		    position: myLatlng,
		    map: map,
		    draggable:true,
		    title:"Drag me!"
		});

		google.maps.event.addListener(marker, 'dragend', function (event) {
		    document.getElementById("field-latitude").value = this.getPosition().lat();
		    document.getElementById("field-longitude").value = this.getPosition().lng();
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYAHflaAbuCFeWhrIv5CUzuj1w3dEFjAM&libraries=places&callback=initMap"
         async defer></script>