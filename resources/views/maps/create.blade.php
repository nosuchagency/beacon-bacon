@extends('layouts.app')

@section('contentheader_title', 'Create new floor')

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Floor details</h3>
        </div>
        {!! Form::open(['route' => 'maps.store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('place_id', 'Place', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('place_id', $places, null, ['class' => 'form-control']) !!}
            </div>
          </div>
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
            {!! Form::label('image', 'Image', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('maps.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection