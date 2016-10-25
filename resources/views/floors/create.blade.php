@extends('layouts.app')

@section('contentheader_title', 'Create floor')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $place->name }}</a></li>
  <li class="active">Creating new floor</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        {!! Form::open(['route' => ['floors.store', $placeId], 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
        {!! Form::hidden('place_id', $placeId) !!}
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('order', 'Floor no.', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::number('order', 0, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">Floor Map</h5>
            <div class="col-sm-10"></div>
          </div>

          <div class="form-group">
            {!! Form::label('image', 'Image', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('map_width_in_centimeters', 'Width in Centimeters', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::number('map_width_in_centimeters', null, ['class' => 'form-control', 'placeholder' => 'Enter width in centimeters']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('map_height_in_centimeters', 'Height in Centimeters', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::number('map_height_in_centimeters', null, ['class' => 'form-control', 'placeholder' => 'Enter height in centimeters']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('map_background_color', 'Background Color (HEX)', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('map_background_color', null, ['class' => 'form-control', 'placeholder' => 'Enter background color in HEX']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('map_walkable_color', 'Walkable Color (HEX)', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('map_walkable_color', null, ['class' => 'form-control', 'placeholder' => 'Enter walkable color in HEX']) !!}
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('places.show', $placeId) }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection