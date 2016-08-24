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
        <h4 class="modal-title">Please POI on Map</h4>
      </div>
      <div class="modal-body">

        <div id="floor-map" class="map" style="background-image: url({{ $location->floor->image }}); height: 620px; overflow: hidden; position: relative; width: 620px;">
		          @if($location->poi->icon)
					<img id="floor-beacon" src="{{ $location->poi->icon }}" style="position: absolute;" />
				  @endif
		</div>

      </div>
      <div class="modal-footer">
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
          <h3 class="box-title">Location details</h3>
        </div>
        <div class="box-body">
	        
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', $location->name, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
	        
          <div class="form-group">
            {!! Form::label('poi_id', 'POI', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('poi_id', $pois, $location->poi_id, ['class' => 'form-control']) !!}
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
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">Map Preview</h5>
            <div class="col-sm-10">
				<button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#mapModal">Place POI on Map</button>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-2"></div>

            <div class="col-sm-10">
				<div id="floor-map-preview" class="map" style="background-image: url({{ $location->floor->image }}); background-size: cover; position: relative; width: 100%;">
		          @if($location->poi->icon)
					<img id="floor-beacon-preview" src="{{ $location->poi->icon }}" style="position: absolute;" />
				  @endif
				</div>				
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('locations.show', [$placeId, $floorId, $location->id]) }}" class="btn btn-default">Cancel</a>
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

var ICON_WIDTH = {{ $location->iconWidth }};
var ICON_HEIGHT = {{ $location->iconHeight }};

function calculate_icon_position_x ( posX ) {
	return Math.round( posX - ( ICON_WIDTH / 2 ) );
}

function calculate_icon_position_y ( posY ) {
	return Math.round( posY - ( ICON_HEIGHT / 2 ) );	
}

function map_preview () {
	var floor_map_preview_width = $( '#floor-map-preview' ).width();

	var ratio = floor_map_preview_width / MAP_WIDTH;
	var floor_map_preview_height = Math.round( MAP_HEIGHT * ratio );

	$( '#floor-map-preview' ).css( 'height', floor_map_preview_height + 'px' );

	var posX = $( '#posX' ).val();
	var posY = $( '#posY' ).val();

	$( '#floor-beacon-preview' ).css( {
		left : calculate_icon_position_x( posX * ratio ),
		top :  calculate_icon_position_y( posY * ratio )
	} );
}

$( window ).resize( function () {
	map_preview();
} );

$( document ).ready( function ( ) {
	map_preview();

	$( '#floor-beacon' ).css( {
		left : calculate_icon_position_x( {{ $location->posX ? $location->posX : 25 }} ),
		top : calculate_icon_position_y( {{ $location->posY ? $location->posY : 25 }} )
	} );

	$( '#floor-map' ).backgroundDraggable( {
		dragging: function ( xPos, yPos ) {
			backgroundPosition = $('#floor-map').css('background-position').split(' ');

			backgroundPositionX = parseInt( backgroundPosition[0], 10 );
			backgroundPositionY = parseInt( backgroundPosition[1], 10 );	

			var posX = parseInt( $( '#posX' ).val(), 10 ) + backgroundPositionX;			
			var posY = parseInt( $( '#posY' ).val(), 10 ) + backgroundPositionY;

			$( '#floor-beacon' ).css( {
				left : calculate_icon_position_x( posX ),
				top : calculate_icon_position_y( posY )
			} );
		}
	} );

	$( '#floor-beacon' ).draggable( {
		containment: 'parent',
		opacity: .7,
		stop: function ( event, icon ) {
			backgroundPosition = $('#floor-map').css('background-position').split(' ');

			backgroundPositionX = parseInt( backgroundPosition[0], 10 );
			backgroundPositionY = parseInt( backgroundPosition[1], 10 );			

			var posX = Math.round( icon.position.left + ( ICON_WIDTH / 2 ) + Math.abs( backgroundPositionX ) );
			var posY = Math.round( icon.position.top + ( ICON_HEIGHT / 2 ) + Math.abs( backgroundPositionY ) );

			$( '#posX' ).val( posX );
			$( '#posY' ).val( posY );

			map_preview();
		}
	} );
} );
</script>
@endsection