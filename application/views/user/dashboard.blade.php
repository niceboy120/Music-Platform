@layout('master.index')

@section('content')
	<h1>Dashboard</h1>
	Welcome {{$user->username}}

	<hr />
	<br />
	<div class="row">
		<div class="span13">
			<?php echo HTML::image('img/thumbnails/thumb.jpg', "Drop It!", array('style' => 'width:220px;border:3px solid #fff;'));?>
			<?php echo HTML::image('img/thumbnails/dubstep.jpg', "Drop It!", array('style' => 'width:220px;border:3px solid #fff;'));?>
			<?php echo HTML::image('img/thumbnails/dnb.jpg', "Drop It!", array('style' => 'width:220px;border:3px solid #fff;'));?>
			<?php echo HTML::image('img/thumbnails/house.jpg', "Drop It!", array('style' => 'width:220px;border:3px solid #fff;'));?>
		</div>
	</div>


	@include('tracks.list')

@endsection