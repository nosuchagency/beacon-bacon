@extends('layouts.app')

@section('contentheader_title', 'Editing ' . $location->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li><a href="{{ route('places.index') }}">{{__('Places')}}</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $location->place->name }}</a></li>
  <li><a href="{{ route('floors.show', [$placeId, $floorId]) }}">{{ $location->floor->name }}</a></li>
  <li><a href="{{ route('locations.show', [$placeId, $floorId, $location->id]) }}">{{ $location->name }}</a></li>
  <li class="active">{{__('Editing')}}</li>
</ol>
@endsection

@section('content')

{!! Form::open(['route' => ['locations.update', $placeId, $floorId, $location->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
{!! Form::hidden('place_id', $placeId) !!}
{!! Form::hidden('floor_id', $floorId) !!}
{!! Form::hidden('type', 'findable') !!}

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('Details')}}</h3>
        </div>
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('findable_id', __('Type'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('findable_id', $findables, $location->findable ? $location->findable : null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('name', __('Name'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', $location->name, ['class' => 'form-control', 'placeholder' => __('Enter name')]) !!}
            </div>
          </div>

			@if($location->findable)
				<div class="form-group">
					<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">{{__('Parameters')}}</h5>
					<div class="col-sm-10"></div>
				</div>
				@if($location->findable->parameter_one_name)
					<div class="form-group">
						{!! Form::label('parameter_one', $location->findable->parameter_one_name, ['class' => 'col-sm-2 control-label']) !!}

						<div class="col-sm-10">
							{!! Form::text('parameter_one', $location->parameter_one, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_one_name]) !!}
						</div>
					</div>
				@endif

				@if($location->findable->parameter_two_name)
					<div class="form-group">
						{!! Form::label('parameter_two', $location->findable->parameter_two_name, ['class' => 'col-sm-2 control-label']) !!}

						<div class="col-sm-10">
							{!! Form::text('parameter_two', $location->parameter_two, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_two_name]) !!}
						</div>
					</div>
				@endif

				@if($location->findable->parameter_three_name)
					<div class="form-group">
						{!! Form::label('parameter_three', $location->findable->parameter_three_name, ['class' => 'col-sm-2 control-label']) !!}

						<div class="col-sm-10">
							{!! Form::text('parameter_three', $location->parameter_three, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_three_name]) !!}
						</div>
					</div>
				@endif

				@if($location->findable->parameter_four_name)
					<div class="form-group">
						{!! Form::label('parameter_four', $location->findable->parameter_four_name, ['class' => 'col-sm-2 control-label']) !!}

						<div class="col-sm-10">
							{!! Form::text('parameter_four', $location->parameter_four, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_four_name]) !!}
						</div>
					</div>
				@endif

				@if($location->findable->parameter_five_name)
					<div class="form-group">
						{!! Form::label('parameter_five', $location->findable->parameter_five_name, ['class' => 'col-sm-2 control-label']) !!}

						<div class="col-sm-10">
							{!! Form::text('parameter_five', $location->parameter_five, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_five_name]) !!}
						</div>
					</div>
				@endif
			@endif

          <div class="form-group">
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">{{__('Location on Map')}}</h5>
            <div class="col-sm-10"></div>
          </div>

          <div class="form-group">
            {!! Form::label('posX', __('Position X'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('posX', $location->posX, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('posY', __('Position Y'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('posY', $location->posY, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">{{__('Place Findable on Map')}}</h5>
            <div class="col-sm-10" style="text-align: right;">
				<input type="checkbox" id="show-100" /> Show 100%
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-2"></div>

            <div class="col-sm-10">

	            <div id="floor-map-container" style="overflow: scroll; width: 100%;">

					<div id="floor-map" class="map" style="background-image: url({{ $location->floor->getVirtualIconPath() }}?random={{ str_random(60) }}); background-size: cover; cursor: crosshair; overflow: hidden; position: relative; width: 100%; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
						<img id="floor-findable" src="{{URL::asset('/img/font-awesome-dot-circle-o.png')}}" style="cursor: move; position: absolute;" />
					</div>

	            </div>

            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('floors.show', [$placeId, $floorId]) }}" class="btn btn-default">{{__('Cancel')}}</a>
          <button type="submit" class="btn btn-info pull-right">{{__('Save')}}</button>
        </div>
      </div>
  </div>
</div>
{!! Form::close() !!}
@endsection

@section('footer')
<script>

var MAP_WIDTH = {{ $location->mapWidth }};
var MAP_HEIGHT = {{ $location->mapHeight }};

var MAP_WIDTH_CENTIMETERS = {{ $location->mapWidthCentimeters }};
var MAP_HEIGHT_CENTIMETERS = {{ $location->mapHeightCentimeters }};

var ICON_WIDTH = 32;
var ICON_HEIGHT = 32;

var ratio = 1;

function calculate_icon_position_x ( posX ) {
	return Math.round( posX - ( ICON_WIDTH / 2 ) );
}

function calculate_icon_position_y ( posY ) {
	return Math.round( posY - ( ICON_HEIGHT / 2 ) );
}

function floor_map () {

	var floor_map_width = $( '#floor-map-container' ).width();

	ratio = floor_map_width / MAP_WIDTH;
	var floor_map_height = Math.round( MAP_HEIGHT * ratio );

	$( '#floor-map-container' ).css( 'height', floor_map_height + 'px' );

	if ( $( '#show-100' ).is( ':checked') ) {
		ratio = 1;

		$( '#floor-map' ).css( {
			'height' : MAP_HEIGHT + 'px',
			'width' : MAP_WIDTH + 'px'
		} );

	} else {
		$( '#floor-map' ).css( {
			'height' : floor_map_height + 'px',
			'width' : '100%'
		} );
	}

	var posX = $( '#posX' ).val();
	var posY = $( '#posY' ).val();

	$( '#floor-findable' ).css( {
		left : calculate_icon_position_x( posX * ratio ),
		top : calculate_icon_position_y( posY * ratio )
	} );
}

$( window ).resize( function () {
	floor_map();
} );

$( document ).ready( function ( ) {
	floor_map();

	$( '#show-100' ).click( function () {
		floor_map();
	} );

	$( '#posX' ).keyup( function() {
		floor_map();
	} );

	$( '#posY' ).keyup( function() {
		floor_map();
	} );

	$( '#floor-map' ).dblclick( function ( event ) {

		var posX = Math.round( event.offsetX / ratio );
		var posY = Math.round( event.offsetY / ratio );

		$( '#posX' ).val( posX );
		$( '#posY' ).val( posY );

		$( '#floor-findable' ).animate( {
			left : calculate_icon_position_x( event.offsetX ),
			top : calculate_icon_position_y( event.offsetY )
		} );
	} );

	$( '#floor-findable' ).draggable( {
		containment: 'parent',
		opacity: .7,
		stop: function ( event, icon ) {
			var posX = Math.round( ( icon.position.left + ( ICON_WIDTH / 2 ) ) / ratio );
			var posY = Math.round( ( icon.position.top + ( ICON_HEIGHT / 2 ) ) / ratio );

			$( '#posX' ).val( posX );
			$( '#posY' ).val( posY );
		}
	} );
} );
</script>
@endsection