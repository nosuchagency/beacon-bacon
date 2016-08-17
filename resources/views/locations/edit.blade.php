@extends('layouts.app')

@section('contentheader_title', 'Edit ' . $location->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $location->place->name }}</a></li>
  <li><a href="{{ route('floors.show', [$placeId, $floorId]) }}">{{ $location->floor->name }}</a></li>
  <li><a href="{{ route('locations.show', [$placeId, $floorId, $location->id]) }}">{{ $location->floor->name }}</a></li>
  <li class="active">Edit location</li>
</ol>
@endsection

@section('content')
{!! Form::open(['route' => ['locations.update', $placeId, $floorId, $location->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
{!! Form::hidden('place_id', $placeId) !!}
{!! Form::hidden('floor_id', $floorId) !!}
{!! Form::hidden('posX', $location->posX ? $location->posX : 10, ['id' => 'posX']) !!}
{!! Form::hidden('posY', $location->posY ? $location->posY : 10, ['id' => 'posY']) !!}
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Location details</h3>
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
        </div>
        <div class="box-footer">
          <a href="{{ route('locations.show', [$placeId, $floorId, $location->id]) }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Location on floor</h3>
        </div>
        <div class="box-body">
          <div class="floor" style="position: relative; width: {{ $location->floorWidth }}px; height: {{ $location->floorHeight }}px; background-image: url({{ $location->floor->image }})">
          @if($location->poi->icon)
            <img src="{{ $location->poi->icon }}" style="cursor: move" id="draggable" />
          @endif
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
$(document).ready(function(){
  $('#draggable').css({
    left: {{ $location->posX ? $location->posX : 25 }},
    top: {{ $location->posY ? $location->posY : 25 }}
  });

  $('#draggable').draggable({
    containment: 'parent',
    opacity: .7,
    stop: function(event, icon){
      $('#posX').val(icon.position.left);
      $('#posY').val(icon.position.top);
    }
  });
});
</script>
@endsection