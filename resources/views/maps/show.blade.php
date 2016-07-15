@extends('layouts.app')

@section('contentheader_title', $map->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li><a href="{{ route('places.show', $map->place_id) }}">{{ $map->place->name }}</a></li>
  <li class="active">{{ $map->name }}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Floor details</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>Place</strong>
            </div>
            <div class="col-sm-10">
              {{ $map->place->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $map->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Floor no.</strong>
            </div>
            <div class="col-sm-10">
              {{ $map->order }}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('places.show', $placeId) }}" class="btn btn-default">Back</a>
          <a href="{{ route('maps.edit', [$placeId, $map->id]) }}" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Locations</h3>
        <div class="pull-right box-tools">
          <a href="{{ route('locations.create', [$placeId, $map->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add location</a>
        </div>
      </div>
      <div class="box-body no-padding">
        <table class="table">
            <tbody>
              <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Place</th>
                <th>Floor</th>
                <th>Category</th>
                <th class="text-right">Actions</th>
              </tr>
            @foreach($map->locations as $index => $location)
              <tr>
                <td>{{ $index+1 }}</td>
                <td><a href="{{ route('locations.show', [$placeId, $map->id, $location->id]) }}">{{ $location->name }}</a></td>
                <td>{{ $location->place->name }}</td>
                <td>{{ $location->map->name }}</td>
                <td>{{ $location->category->name }}</td>
                <td class="text-right">
                  {!! Form::open(['route' => ['locations.destroy', $placeId, $map->id, $location->id], 'method' => 'DELETE']) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                  <a href="{{ route('locations.edit', [$placeId, $map->id, $location->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                  {!! Form::close() !!}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Floor image</h3>
      </div>
      <div class="box-body">
        @if($map->image)
        <div style="position: relative; width: {{ $map->width }}px; height: {{ $map->height }}px; background-image: url({{ $map->image }});">
          @foreach($map->locations as $index => $location)
            <img src="{{ $location->category->icon }}" style="position: absolute; top: {{ $location->posY }}px; left: {{ $location->posX }}px" />
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection