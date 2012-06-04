@section('content')
@parent
	<br /><br />
	<div class="row">
		<div class="span10">
			<h1>Tracks</h1>
			<hr />
			<?php echo render_each('tracks.each', $tracks, 'track'); ?>
		</div>	
	</div>
@endsection