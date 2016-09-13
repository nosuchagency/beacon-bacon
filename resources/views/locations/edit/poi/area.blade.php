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

<div class="modal fade" id="mapModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 650px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Draw POI on Map</h4>
      </div>
      <div class="modal-body">

        <div class="map" style="height: 620px; overflow: scroll; position: relative; width: 620px;">
	        <canvas id="floor-map" height="{{ $location->mapHeight }}" width="{{ $location->mapWidth }}" style="background-image: url({{ $location->floor->image }}); cursor: crosshair;"></canvas>
		</div>

      </div>
      <div class="modal-footer">
        <button id="canvas_reset_button" type="button" class="btn btn-default">Start Over</button>	      
        <button type="button" class="btn btn-default" data-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
</div>

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
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">Map Preview</h5>
            <div class="col-sm-10">
				<button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#mapModal">Draw POI on Map</button>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-2"></div>

            <div class="col-sm-10">
				<canvas id="floor-map-preview" class="map" style="background-image: url({{ $location->floor->image }}); background-size: cover; position: relative; width: 100%;"></canvas>				
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

function map_preview () {
	var floor_map_preview_width = $( '#floor-map-preview' ).width();

	var ratio = floor_map_preview_width / MAP_WIDTH;
	var floor_map_preview_height = Math.round( MAP_HEIGHT * ratio );

	var canvas = $( '#floor-map-preview' );
	canvas.css( 'height', floor_map_preview_height + 'px' );
    canvas.attr( 'height', floor_map_preview_height ).attr( 'width', floor_map_preview_width );
	
	var area = $( '#area' );
	var context = canvas[0].getContext( '2d' );

	if ( area.val().length > 0 ) {
        points = area.val().split( ',' ).map( function ( point ) {
			return parseInt( point * ratio, 10 );
        } );
	} else {
		points = [];
	}	

	if ( points.length < 2 ) {
		return false;
	}

	context.globalCompositeOperation = 'destination-over';
	context.fillStyle = 'rgb(255, 255, 255)'
	context.strokeStyle = 'rgb(0, 0, 0)';
	context.lineWidth = 1;
	
	context.beginPath();
	context.moveTo( points[0], points[1] );
	
	for ( var i = 0; i < points.length; i += 2 ) {
		context.fillRect( points[i] - 2, points[i+1] - 2, 4, 4 );
		context.strokeRect( points[i] - 2, points[i+1] - 2, 4, 4 );

		if ( points.length > 2 && i > 1 ) {
			context.lineTo( points[i], points[i+1] );
		}
	}

	context.closePath();
	
	var rgb = hexToRgb( AREA_COLOR );
	context.fillStyle = 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', 0.3)';
	context.fill();
	context.stroke();
}

$( window ).resize( function () {
	map_preview();
} );

$( document ).ready( function ( ) {
	map_preview();

    $( '#area' ).on( 'keyup', function () {
		map_preview();
    } );

//	map_modal();

    $( '#floor-map' ).canvasAreaDraw( {
	    'input' : '#area',
	    'rgb' : hexToRgb( AREA_COLOR ),
	    'reset' : '#canvas_reset_button'
    } );

} );
</script>
@endsection