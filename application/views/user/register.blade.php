@layout('master.index')
@section('content')
	<h1>Register</h1>
	<hr />
	<?php if(isset($validation) || isset($error)): ?>
		<div class="span7">
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<?php
					//Username
					if (isset($validation) && $validation->errors->has('username'))
					{
					    echo $validation->errors->first('username', '<strong>:message</strong><br />');
					}

					//Email
					if (isset($validation) && $validation->errors->has('email'))
					{
					    echo $validation->errors->first('email', '<strong>:message</strong><br />');
					}

					//Password
					if (isset($validation) && $validation->errors->has('password'))
					{
					    echo $validation->errors->first('password', '<strong>:message</strong><br />');
					}

					//ConfirmPassword
					if (isset($validation) && $validation->errors->has('confirmpassword'))
					{
					    echo $validation->errors->first('confirmpassword', '<strong>:message</strong><br />');
					}


					if(isset($error))
						echo "<strong>" . $error . "</strong>";

				?>
			</div>
		</div>
	<?php endif; ?>

	<?php echo Form::open('register', 'POST', array('class' => 'form-horizontal')); ?>
		<fieldset>
			<?php echo Form::token(); ?>

			<!-- Username -->
			<div class="control-group">
				<?php echo Form::label('username', 'Username', array('class' => 'control-label')); ?>
				<div class="controls">
				<?php echo Form::text('username', Input::get('username') , array('class' => 'input-xlarge')); ?>
				</div>
			</div>
			<br />

			<!-- Email -->
			<div class="control-group">
				<?php echo Form::label('email', 'Email', array('class' => 'control-label')); ?>
				<div class="controls">
				<?php echo Form::text('email', Input::get('email') , array('class' => 'input-xlarge')); ?>
				</div>
			</div>
			<br />

			<!-- Password -->
			<div class="control-group">
				<?php echo Form::label('password', 'Password', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo Form::password('password', array('class' => 'input-xlarge')); ?>
				</div>
			</div>
			<br />

			<!-- Confirm Password -->
			<div class="control-group">
				<?php echo Form::label('confirmpassword', 'Confirm Password', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo Form::password('confirmpassword', array('class' => 'input-xlarge')); ?>
				</div>
			</div>

			<div class="form-actions">
				<?php echo Form::submit('Login', array('class' => 'btn btn-primary')); ?>
			</div>

		</fieldset>
	<?php echo Form::close(); ?>

@endsection