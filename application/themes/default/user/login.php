<div class="row-fluid">
	<div class="span4">&nbsp;</div>
	<div class="span4 pagination-centered">
		<div class="container-fluid login-container">
			<div class="page-header">
				<h1>Slate <small>Log In</small></h1>
				<p>Sign in using your registered account:</p>
			</div>

			<?php echo Form::open(); ?>

			<?php if ( isset( $login_error )): ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Error!&nbsp;</strong><?php echo $login_error; ?>
			</div>
			<?php endif; ?>

			<div class="control-group">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span><?php echo Form::input( 'email', Input::post( 'email' ), array( 'placeholder' => 'Username' )); ?>
				</div>
			</div>

			<div class="control-group">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-lock"></i></span><?php echo Form::password( 'password', null, array( 'placeholder' => 'Password' )); ?>
				</div>
			</div>

			<div class="actions">
				<?php echo Form::submit( array('value' => 'Login', 'name' => 'submit', 'class' => 'btn btn-primary btn-large')); ?>
			</div>
			<?php echo Form::close(); ?>
		</div>
	</div>
</div>