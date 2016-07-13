@extends('layouts.app')

@section('contentheader_title', 'Edit ' . $location->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $location->place->name }}</a></li>
  <li><a href="{{ route('maps.show', [$placeId, $mapId]) }}">{{ $location->map->name }}</a></li>
  <li><a href="{{ route('locations.show', [$placeId, $mapId, $location->id]) }}">{{ $location->map->name }}</a></li>
  <li class="active">Edit location</li>
</ol>
@endsection

@section('content')
{!! Form::open(['route' => ['locations.update', $placeId, $mapId, $location->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
{!! Form::hidden('place_id', $placeId) !!}
{!! Form::hidden('map_id', $mapId) !!}
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Location details</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('category_id', 'Category', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('category_id', $categories, $location->category_id, ['class' => 'form-control']) !!}
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
          <a href="{{ route('maps.show', [$placeId, $mapId]) }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Location on map</h3>
        </div>
        <div class="box-body">
          <img src="{{ asset('uploads/maps/' . $mapId . '/' . $location->map->image) }}" class="img-responsive" />
        </div>
        <div class="box-footer">
          <a href="{{ route('maps.show', [$placeId, $mapId]) }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
      </div>
  </div>
</div>
{!! Form::close() !!}
@endsection