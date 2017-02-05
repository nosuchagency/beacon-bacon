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
{!! Form::hidden('type', 'poi') !!}

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('poi_id', 'POI', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('poi_id', $pois, $location->poi_id, ['class' => 'form-control']) !!}
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
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">Place POI on Map</h5>
            <div class="col-sm-10" style="text-align: right;">
				<input type="checkbox" id="show-100" /> Show 100%				
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-2"></div>

            <div class="col-sm-10">
	            
	            <div id="floor-map-container" style="overflow: scroll; width: 100%;">

					<div id="floor-map" class="map" style="background-image: url({{ $location->floor->getVirtualIconPath() }}?random={{ str_random(60) }}); background-size: cover; cursor: crosshair; overflow: hidden; position: relative; width: 100%; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
				          @if($location->poi->icon)
							<img id="floor-poi" src="{{ $location->poi->getVirtualIconPath() }}" style="cursor: move; height: {{ $location->iconHeight }}px; position: absolute; width: {{ $location->iconWidth }}px;" />
						  @endif
					</div>

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

var ICON_WIDTH_ORIGINAL = {{ $location->iconWidth or 0 }};
var ICON_HEIGHT_ORIGINAL = {{ $location->iconHeight or 0 }};

var ICON_WIDTH = {{ $location->iconWidth or 0 }};
var ICON_HEIGHT = {{ $location->iconHeight or 0 }};

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
		
		ICON_HEIGHT = ICON_HEIGHT_ORIGINAL * 4;
		ICON_WIDTH = ICON_WIDTH_ORIGINAL * 4;
		
	} else {
		$( '#floor-map' ).css( {
			'height' : floor_map_height + 'px',
			'width' : '100%'
		} );
		
		ICON_HEIGHT = ICON_HEIGHT_ORIGINAL;
		ICON_WIDTH = ICON_WIDTH_ORIGINAL;
	}

	var posX = $( '#posX' ).val();
	var posY = $( '#posY' ).val();

	$( '#floor-poi' ).css( {
		height : ICON_HEIGHT,
		left : calculate_icon_position_x( posX * ratio ),
		top : calculate_icon_position_y( posY * ratio ),
		width : ICON_WIDTH		
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

		$( '#floor-poi' ).animate( {
			left : calculate_icon_position_x( event.offsetX ),
			top : calculate_icon_position_y( event.offsetY )
		} );
	} );

	$( '#floor-poi' ).draggable( {
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