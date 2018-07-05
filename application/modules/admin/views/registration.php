<div class="login-box">

	<div class="login-logo"><b>Registration Form</b></div>

	<div class="login-box-body">
		<p class="login-box-msg">User Info</p>
		<?php echo $form->open(); ?>
			<?php echo $form->messages(); ?>
			<?php //echo $form->bs3_text('Username', 'username', ENVIRONMENT==='development' ? 'webmaster' : ''); ?>
			<?php echo $form->bs3_text('First Name', 'first_name'); ?>
			<?php echo $form->bs3_text('Last Name', 'last_name'); ?>
			<?php echo $form->bs3_text('Username', 'username'); ?>
			<?php echo $form->bs3_text('Email', 'email'); ?>

			<?php echo $form->bs3_password('Password', 'password'); ?>
			<?php echo $form->bs3_password('Retype Password', 'retype_password'); ?>

			<div class="row">
				<div class="col-xs-8">
					<?php echo $form->bs3_submit('Register', 'btn btn-primary btn-block btn-flat'); ?>
					<a href="login" class="btn btn-primary btn-block btn-flat">Sign In</a>
				</div>
			</div>
		<?php echo $form->close(); ?>
	</div>

</div>