<?php echo $form->messages(); ?>

<div class="row">

	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Dorm Info</h3>
			</div>
			<div class="box-body">
				<?php echo $form->open(); ?>

					<?php echo $form->bs3_text('Name', 'name'); ?>
					<?php echo $form->bs3_text('Size', 'size'); ?>
					<?php echo $form->bs3_text('Rate', 'rate'); ?>
					<?php echo $form->bs3_textarea('Amenities', 'amenities'); ?>
					<?php echo $form->bs3_textarea('Policy', 'policy'); ?>
					<?php echo $form->bs3_text('Contact No.', 'contact_no'); ?>
					<?php echo $form->bs3_text('Contact Name', 'contact_name'); ?>
					<?php echo $form->bs3_text('Latitude', 'latitude'); ?>
					<?php echo $form->bs3_text('Longitude', 'longitude'); ?>
					<div id="map" style="height:600px;"></div>
					<?php echo $form->bs3_submit(); ?>
					
				<?php echo $form->close(); ?>
			</div>
		</div>
	</div>
	
</div>

<script>
	function initMap() {
		var myLatlng = new google.maps.LatLng(14.5995124,120.9842195);
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
		    document.getElementById("latitude").value = this.getPosition().lat();
		    document.getElementById("longitude").value = this.getPosition().lng();
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYAHflaAbuCFeWhrIv5CUzuj1w3dEFjAM&libraries=places&callback=initMap"
         async defer></script>