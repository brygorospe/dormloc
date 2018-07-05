<div class="login-box">

	<div class="login-logo"><b><?php echo $site_name; ?></b></div>

	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session</p>
		<?php echo $form->open(); ?>
			<?php echo $form->messages(); ?>
			<?php echo $form->bs3_text('Username', 'username', ENVIRONMENT==='development' ? 'webmaster' : ''); ?>
			<?php echo $form->bs3_password('Password', 'password', ENVIRONMENT==='development' ? 'webmaster' : ''); ?>
			<div class="row">
				<div class="col-xs-5">
					<div class="checkbox">
						<label><input type="checkbox" name="remember"> Remember Me</label>
					</div>
				</div>
				<div class="col-xs-7">
					<?php echo $form->bs3_submit('Sign In', 'btn btn-primary btn-block btn-flat'); ?>
					<a href="register" class="btn btn-primary btn-block btn-flat">Register</a>
				</div>
			</div>
		<?php echo $form->close(); ?>
	</div>

</div>