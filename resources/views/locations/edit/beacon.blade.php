@extends('layouts.app')

@section('contentheader_title', 'Editing ' . $location->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $location->place->name }}</a></li>
  <li><a href="{{ route('floors.show', [$placeId, $floorId]) }}">{{ $location->floor->name }}</a></li>
  <li><a href="{{ route('locations.show', [$placeId, $floorId, $location->id]) }}">{{ $location->name }}</a></li>
  <li class="active">Editing</li>
</ol>
@endsection

@section('content')

{!! Form::open(['route' => ['locations.update', $placeId, $floorId, $location->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
{!! Form::hidden('place_id', $placeId) !!}
{!! Form::hidden('floor_id', $floorId) !!}
{!! Form::hidden('type', 'beacon') !!}

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        <div class="box-body">
	        
          <div class="form-group">
            {!! Form::label('beacon_id', 'Beacon', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('beacon_id', $beacons_select, $location->beacon->id, ['class' => 'form-control']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', $location->name, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>          

          <div class="form-group">
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">Location on Map</h5>
            <div class="col-sm-10"></div>
          </div>

          <div class="form-group">
            {!! Form::label('posX', 'Position X', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('posX', $location->posX, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('posY', 'Position Y', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('posY', $location->posY, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">Place Beacon on Map</h5>
            <div class="col-sm-10" style="text-align: right;">
				<input type="checkbox" id="show-grid" /> Show Grid&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="show-100" /> Show 100%				
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-2"></div>

            <div class="col-sm-10">
	            
	            <div id="floor-map-container" style="overflow: scroll; width: 100%;">

					<div id="floor-map" class="map" style="background-image: url({{ $location->floor->image }}); background-size: cover; cursor: crosshair; overflow: hidden; position: relative; width: 100%; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
						<div id="floor-map-grid" style="height: 100%; position: absolute; width: 100%;"></div>
						<div style="height: 100%; position: absolute; width: 100%;"></div>						
						<img id="floor-beacon" src="{{URL::asset('/img/font-awesome-bullseye.png')}}" style="cursor: move; position: absolute;" />
					</div>

	            </div>

            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('floors.show', [$placeId, $floorId]) }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
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

function grid () {
	if ( ! $( '#show-grid' ).is( ':checked') ) {
		$( '#floor-map-grid' ).hide();
		
		return true;	
	}

	var map_width_meters = Math.ceil( MAP_WIDTH_CENTIMETERS / 100 );
	var map_height_meters = Math.ceil( MAP_HEIGHT_CENTIMETERS / 100 );

	var td_width_pixels = Math.ceil( MAP_WIDTH / map_width_meters * ratio );	
	var td_height_pixels = Math.ceil( MAP_HEIGHT / map_height_meters * ratio );

	var html = '<table border="1">';
	for ( var row_counter = 0; row_counter <= map_height_meters; row_counter++ ) {
   		html += '<tr>';
   		
   		for ( var column_counter = 0; column_counter <= map_width_meters; column_counter++ ) {    	
	   		html += '<td style="height: ' + td_height_pixels + 'px; width: ' + td_width_pixels + 'px;"></td>';    	
	   	}

   		html += '</tr>';
	}

	html += '</table>';
	$( '#floor-map-grid' ).html( html ).show();
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

	$( '#floor-beacon' ).css( {
		left : calculate_icon_position_x( posX * ratio ),
		top : calculate_icon_position_y( posY * ratio )
	} );
	
	grid();
}

$( window ).resize( function () {
	floor_map();
} );

$( document ).ready( function ( ) {
	floor_map();
		
	$( '#show-grid' ).click( function () {
		floor_map();
	} );

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
		
		console.log( event );
		
		var posX = Math.round( event.offsetX / ratio );
		var posY = Math.round( event.offsetY / ratio );

		$( '#posX' ).val( posX );
		$( '#posY' ).val( posY );

		$( '#floor-beacon' ).animate( {
			left : calculate_icon_position_x( event.offsetX ),
			top : calculate_icon_position_y( event.offsetY )
		} );
	} );

	$( '#floor-beacon' ).draggable( {
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