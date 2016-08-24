@extends('layouts.app')

@section('contentheader_title', $floor->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li><a href="{{ route('places.show', $floor->place_id) }}">{{ $floor->place->name }}</a></li>
  <li class="active">{{ $floor->name }}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        <div class="box-body">

          <div class="row">
            <div class="col-sm-2">
              <strong>Place</strong>
            </div>
            <div class="col-sm-10">
              {{ $floor->place->name }}
            </div>
          </div>

          <div class="row">
            <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $floor->name }}
            </div>
          </div>

          <div class="row">
            <div class="col-sm-2">
              <strong>Floor no.</strong>
            </div>
            <div class="col-sm-10">
              {{ $floor->order }}
            </div>
          </div>

          <div class="row">
            <div class="col-sm-2">
              <strong>Map - Width in Centimeters</strong>
            </div>
            <div class="col-sm-10">
              {{ $floor->map_width_in_centimeters }}
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-2">
              <strong>Map - Height in Centimeters</strong>
            </div>
            <div class="col-sm-10">
              {{ $floor->map_height_in_centimeters }}
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-2">
              <strong>Map - Width in Pixels</strong>
            </div>
            <div class="col-sm-10">
              {{ $floor->map_width_in_pixels }}
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-2">
              <strong>Map - Height in Pixels</strong>
            </div>
            <div class="col-sm-10">
              {{ $floor->map_height_in_pixels }}
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-2">
              <strong>Map - Pixel/Centimeter Ratio</strong>
            </div>
            <div class="col-sm-10">
              {{ $floor->map_pixel_to_centimeter_ratio }}
            </div>
          </div>


          <div class="row">
            <div class="col-sm-2">
              <strong>Map - Walkable Color in HEX</strong>
            </div>
            <div class="col-sm-10">
              {{ $floor->map_walkable_color }}
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('places.show', $placeId) }}" class="btn btn-default">Back</a>
          <a href="{{ route('floors.edit', [$placeId, $floor->id]) }}" class="btn btn-info pull-right">Edit</a>
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
          <a href="{{ route('locations.create', [$placeId, $floor->id, 'poi']) }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add POI</a>
          <a href="{{ route('locations.create', [$placeId, $floor->id, 'beacon']) }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Beacon</a>
          <a href="{{ route('locations.create', [$placeId, $floor->id, 'ims']) }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add IMS</a>                    
        </div>
      </div>
      <div class="box-body no-padding">
        <table class="table">
            <tbody>
              <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>POI</th>
                <th>Beacon</th>
                <th>IMS</th>
                <th class="text-right">Actions</th>
              </tr>
            @foreach($floor->locations as $index => $location)
              <tr>
                <td>{{ $index+1 }}</td>
                <td><a href="{{ route('locations.show', [$placeId, $floor->id, $location->id]) }}">{{ $location->name or 'Unnamed' }}</a></td>
                <td>{{ $location->poi->name or 'n/a' }}</td>
                <td>{{ $location->beacon->beacon_uid or 'n/a' }}</td>
                <td>n/a</td>
                <td class="text-right">
                  {!! Form::open(['route' => ['locations.destroy', $placeId, $floor->id, $location->id], 'method' => 'DELETE']) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                  <a href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}" class="btn btn-primary btn-sm">Edit</a>
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
        <h3 class="box-title">Map Preview</h3>
      </div>
      <div class="box-body">
        @if($floor->image)
        <div style="position: relative; width: {{ $floor->width }}px; height: {{ $floor->height }}px; background-image: url({{ $floor->image }});">
          @foreach($floor->locations as $index => $location)
	          
	          @if($location->poi)
			  	<img src="{{ $location->poi->icon }}" style="position: absolute; top: {{ $location->posY }}px; left: {{ $location->posX }}px;" />
			  @endif
			  	
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection