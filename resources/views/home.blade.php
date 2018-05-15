@extends('layouts.app') @section('content')
<div class="landing-page">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<section class="landing-header">

				<h2 class="landing-title">
					Dobrodošli na prenovljenem portalu Predlagam.vladi.si!
				</h2>

				<h3 class="landing-subtitle">
					V sodelovanju z uporabniki smo izdelali novo verzijo portala.
				</h3>

				<div class="call-to-action">
					<a href="/threads/create" class="btn btn-call-add btn-lg">
						@if(Auth::check()) Dodaj nov predlog @else Prijavi se @endif
					</a>
					<a href="/threads" class="btn btn-call-search btn-lg">Vstopi na portal</a>
				</div>
			</section>
		</div>
	</div>
	<!-- Statistics -->
	<div class="row">
		<div class="landing-statistics container-fluid text-center">
			<div class="landing-statistics-title">
				<h2>STATISTIKA</h2>
				<h4>Za pretekli mesec</h4>
				<br>
			</div>
			<div class="landing-statistics-items">
				<div class="statistics-item col-sm-4">
					<span class="fa fa-lightbulb-o fa-3x"></span>
					<h4>{{ $threadCount }}</h4>
					<p>NOVIH PREDLOGOV</p>
				</div>
				<div class="statistics-item col-sm-4">
					<span class="fa fa-trophy fa-3x"></span>
					<h4>{{ $acceptedThreadCount }}</h4>
					<p>SPREJETIH PREDLOGOV</p>
				</div>
				<div class="statistics-item col-sm-4">
					<span class="fa fa-thumbs-up fa-3x"></span>
					<h4>{{ $voteCount }}</h4>
					<p>NOVIH GLASOV</p>
				</div>
				<div class="statistics-item col-sm-4">
					<span class="fa fa-commenting fa-3x"></span>
					<h4>{{ $replyCount }}</h4>
					<p>NOVIH KOMENTARJEV</p>
				</div>
				<div class="statistics-item col-sm-4">
					<span class="fa fa-line-chart fa-3x"></span>
					<h4>{{ strtoupper($popularCategory) }}</h4>
					<p>NAJPOGOSTEJŠA TEMATIKA</p>
				</div>
				<div class="statistics-item col-sm-4">
					<span class="fa fa-user-plus fa-3x"></span>
					<h4>{{ $newUserCount }}</h4>
					<p>NOVIH UPORABNIKOV</p>
				</div>
			</div>
		</div>
	</div>
	<!-- /Statistics -->

	<!-- Implementation -->
	<div class="row">
		<div class="landing-implementation container-fluid">
			<div class="implementation-title">
				<h2>STATUS PREDLOGOV</h2>
				<h4>V IMPLEMENTACIJI</h4>
				<br>
			</div>
			<div class="implementation-items">
				@foreach($newslist as $news)
				<div class="col-sm-6 col-md-4">
					<div class="thumbnail">
						<img src="/storage/{{$news->thumbnail}}" width="100%" height="300px">
						<div class="caption">
							<h3>
								<a href="{{ $news->path() }}">{{ $news->title }}</a>
							</h3>
							<p>{{ str_limit($news->body, 50) }}</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<!-- /Statistics -->
</div>

</div>
@endsection