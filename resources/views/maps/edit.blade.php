@extends('layouts.app')

@section('contentheader_title', 'Edit ' . $map->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li><a href="{{ route('places.show', $map->place_id) }}">{{ $map->place->name }}</a></li>
  <li class="active">Edit floor</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Floor details</h3>
        </div>
        {!! Form::open(['route' => ['maps.update', $placeId, $map->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}
        {!! Form::hidden('place_id', $placeId) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', $map->name, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('order', 'Floor no.', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::number('order', 0, ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('image', 'Image', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              @if($map->image)
                <img src="{{ $map->image }}" class="img-responsive" />
              @endif
              {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('maps.show', [$placeId, $map->id]) }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection