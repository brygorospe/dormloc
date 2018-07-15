<?php echo $form->messages(); ?>

<div class="row">

	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Residence Info</h3>
			</div>
			<div class="box-body">
				<?php echo $form->open(); ?>

					<?php echo $form->bs3_text('Name', 'name'); ?>
					<?php echo $form->bs3_text('Size', 'size'); ?>
					<?php echo $form->bs3_text('Rate', 'rate'); ?>
					<?php echo $form->bs3_dropdown('Type', 'type', array('CONDO'=>'Condo', 'APARTMENT'=>'Apartment', 'DORM'=>'Dorm')); ?>
					<?php echo $form->bs3_dropdown('Room Sharing', 'isSharing', array(0=>'No', 1=>'Yes')); ?>
					<?php echo $form->bs3_dropdown('Room Availability', 'room_availability', array(1=>'Yes', 0=>'No')); ?>
					<?php //echo $form->bs3_textarea('Amenities', 'amenities'); ?>
					<div class="form-group">
						<label for="amenities">Amenities</label>
						<div class="form-control" style="height:auto;">
							<label style="width:100px;">Pool</label> <input type="checkbox" name="amenities[]" id="amenities" value="Pool" /><br/>
							<label style="width:100px;">Wifi</label> <input type="checkbox" name="amenities[]" id="amenities" value="Wifi" /><br/>
							<label style="width:100px;">Event Room</label> <input type="checkbox" name="amenities[]" id="amenities" value="Event Room" /><br/>
							<label style="width:100px;">Canteen</label> <input type="checkbox" name="amenities[]" id="amenities" value="Canteen" /><br/>
							<label style="width:100px;">Study Area</label> <input type="checkbox" name="amenities[]" id="amenities" value="Study Area" /><br/>
							<label style="width:100px;">Others:</label> <input type="text" name="amenities[]" id="amenities" />
						</div>
					</div>
					<?php //echo $form->bs3_textarea('Policy', 'policy'); ?>
					<div class="form-group">
						<label for="policy">Policy</label>
						<div class="form-control" style="height:auto;">
							<label style="width:100px;">No Smoking</label> <input type="checkbox" name="policy[]" id="policy" value="No Smoking" /><br/>
							<label style="width:100px;">Curfew Hours</label> <input type="checkbox" name="policy[]" id="policy" value="Curfew Hours" /><br/>
							<label style="width:100px;">Others:</label> <input type="text" name="policy[]" id="policy" />
						</div>
					</div>
					<?php echo $form->bs3_textarea('Room Details', 'room_details'); ?>
					<?php echo $form->bs3_text('Contact No.', 'contact_no'); ?>
					<?php echo $form->bs3_text('Contact Name', 'contact_name'); ?>
					<?php echo $form->bs3_text('Latitude', 'latitude'); ?>
					<?php echo $form->bs3_text('Longitude', 'longitude'); ?>
					<div class="form-group">
						<label for="Photo">Photo</label>
						<input type="file" name="photo" size="20" />
					</div>
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