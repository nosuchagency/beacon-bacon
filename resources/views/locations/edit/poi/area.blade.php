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
            {!! Form::label('area', 'Area', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('area', $location->area, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">Draw POI on Map</h5>
            <div class="col-sm-10">
	            <button type="button" class="btn btn-info pull-right" id="canvas_reset_button">Start Over</button>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-2"></div>

            <div class="col-sm-10">
	            
	            <div id="floor-map-container" style="overflow: scroll; width: 100%;">
					<canvas id="floor-map" height="{{ $location->mapHeight }}" width="{{ $location->mapWidth }}" style="background-image: url({{ $location->floor->getVirtualIconPath() }}?random={{ str_random(60) }}); cursor: crosshair;"></canvas>
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

var AREA_COLOR = '{{ $location->poi->color }}';

function hexToRgb ( hex ) {
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace( shorthandRegex, function ( m, r, g, b ) {
        return r + r + g + g + b + b;
    } );

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec( hex );
    return result ? {
        r : parseInt( result[1], 16 ),
        g : parseInt( result[2], 16 ),
        b : parseInt( result[3], 16 )
    } : null;
}

function floor_map () {
	var floor_map_width = $( '#floor-map-container' ).width();		
		
	ratio = floor_map_width / MAP_WIDTH;
	var floor_map_height = Math.round( MAP_HEIGHT * ratio );

	$( '#floor-map-container' ).css( 'height', floor_map_height + 'px' );
}

$( window ).resize( function () {
	floor_map();
} );

$( document ).ready( function ( ) {

    $( '#floor-map' ).canvasAreaDraw( {
	    'input' : '#area',
	    'rgb' : hexToRgb( AREA_COLOR ),
	    'reset' : '#canvas_reset_button'
    } );

} );
</script>
@endsection