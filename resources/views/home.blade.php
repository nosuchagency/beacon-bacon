@extends('layouts.app')

@section('htmlheader_title', 'Dashboard')

@section('contentheader_title', 'Dashboard')

@section('content')

	<div class="row">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3>{{ $places }}</h3>
						<p>Places</p>
					</div>
					<div class="icon">
						<i class="fa fa-globe"></i>
					</div>
					<a href="{{ route('places.index') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-red">
					<div class="inner">
						<h3>{{ $maps }}</h3>
						<p>Floors</p>
					</div>
					<div class="icon">
						<i class="fa fa-clone"></i>
					</div>
					<a href="{{ route('maps.index') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h3>{{ $locations }}</h3>
						<p>Locations</p>
					</div>
					<div class="icon">
						<i class="fa fa-map-marker"></i>
					</div>
					<a href="{{ route('locations.index') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-blue">
					<div class="inner">
						<h3>{{ $beacons }}</h3>
						<p>Beacons</p>
					</div>
					<div class="icon">
						<i class="fa fa-exclamation-circle"></i>
					</div>
					<a href="{{ route('beacons.index') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
	</div>

@endsection
