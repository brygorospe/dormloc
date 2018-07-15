<div class="login-box">

	<div class="login-logo"><b>Registration Form</b></div>

	<div class="login-box-body">
		<p class="login-box-msg">User Info</p>
		<?php echo $form->open(); ?>
			<?php echo $form->messages(); ?>
			<?php //echo $form->bs3_text('Username', 'username', ENVIRONMENT==='development' ? 'webmaster' : ''); ?>
			<?php echo $form->bs3_text('First Name', 'first_name', '', array('required'=>'required')); ?>
			<?php echo $form->bs3_text('Last Name', 'last_name', '', array('required'=>'required')); ?>
			<?php echo $form->bs3_text('Username', 'username', '', array('required'=>'required')); ?>
			<?php echo $form->bs3_text('Email', 'email', '', array('required'=>'required')); ?>

			<?php echo $form->bs3_password('Password', 'password', '', array('required'=>'required')); ?>
			<?php echo $form->bs3_password('Retype Password', 'retype_password', '', array('required'=>'required')); ?>
			<div class="form-group">
				<label for="Photo">Photo</label>
				<input type="file" name="photo" size="20" />
			</div>
			
			<div class="row">
				<div class="col-xs-8">
					<?php echo $form->bs3_submit('Register', 'btn btn-primary btn-block btn-flat'); ?>
					<a href="login" class="btn btn-primary btn-block btn-flat">Sign In</a>
				</div>
			</div>
		<?php echo $form->close(); ?>
	</div>

</div>