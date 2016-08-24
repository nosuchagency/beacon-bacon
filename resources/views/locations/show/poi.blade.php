@extends('layouts.app')

@section('contentheader_title', $location->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $location->place->name }}</a></li>
  <li><a href="{{ route('floors.show', [$placeId, $floorId]) }}">{{ $location->floor->name }}</a></li>
  <li class="active">{{ $location->name }}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Location details</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>Place</strong>
            </div>
            <div class="col-sm-10">
              {{ $location->place->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Floor</strong>
            </div>
            <div class="col-sm-10">
              {{ $location->floor->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>POI</strong>
            </div>
            <div class="col-sm-10">
              {{ $location->poi->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $location->name }}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('floors.show', [$placeId, $floorId]) }}" class="btn btn-default">Back</a>
          <a href="{{ route('locations.edit', [$placeId, $floorId, $location->id]) }}" class="btn btn-info pull-right">Edit</a>
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
          <div class="floor" style="position: relative; width: {{ $location->mapWidth }}px; height: {{ $location->mapHeight }}px; background-image: url({{ $location->floor->image }})">
          @if($location->poi->icon)
            <img src="{{ $location->poi->icon }}" style="position: absolute; top: {{ $location->posY }}px; left: {{ $location->posX }}px;" />
          @endif
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('floors.show', [$placeId, $floorId]) }}" class="btn btn-default">Back</a>
          <a href="{{ route('locations.edit', [$placeId, $floorId, $location->id]) }}" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
  </div>
</div>
@endsection