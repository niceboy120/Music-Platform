@layout('master.index')
@section('content')
	<h1>Authentication</h1>
	<hr />
	<?php if(isset($validation) || isset($error)): ?>
		<div class="span7">
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<?php
					if (isset($validation) && $validation->errors->has('username'))
					{
					    echo $validation->errors->first('username', '<strong>:message</strong><br />');
					}

					if (isset($validation) && $validation->errors->has('password'))
					{
					    echo $validation->errors->first('password', '<strong>:message</strong><br />');
					}

					if(isset($error))
						echo "<strong>" . $error . "</strong>";

				?>
			</div>
		</div>
	<?php endif; ?>

	<?php echo Form::open('login', 'POST', array('class' => 'form-horizontal')); ?>
		<fieldset>
			<?php echo Form::token(); ?>

			<div class="control-group">
				<!-- Username -->
				<?php echo Form::label('username', 'Username', array('class' => 'control-label')); ?>
				<div class="controls">
				<?php echo Form::text('username', Input::get('username') , array('class' => 'input-xlarge')); ?>
				</div>
			</div>
			<br />

			<div class="control-group">
				<!-- Password -->
				<?php echo Form::label('password', 'Password', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo Form::password('password', array('class' => 'input-xlarge')); ?>
				</div>
			</div>

			<div class="form-actions">
				<?php echo Form::submit('Login', array('class' => 'btn btn-primary')); ?>
			</div>

		</fieldset>
	<?php echo Form::close(); ?>

@endsection