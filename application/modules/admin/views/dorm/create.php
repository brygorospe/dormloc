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
					<?php echo $form->bs3_text('Latitude', 'latitude'); ?>
					<?php echo $form->bs3_text('Longitude', 'longitude'); ?>
					<?php echo $form->bs3_text('Rate', 'rate'); ?>
					<?php echo $form->bs3_text('Size', 'size'); ?>
					<?php echo $form->bs3_textarea('Amenities', 'amenities'); ?>
					<?php echo $form->bs3_textarea('Policy', 'policy'); ?>
					<?php echo $form->bs3_text('Contact No.', 'contact_no'); ?>
					<?php echo $form->bs3_text('Contact Name', 'contact_name'); ?>

					<?php echo $form->bs3_submit(); ?>
					
				<?php echo $form->close(); ?>
			</div>
		</div>
	</div>
	
</div>