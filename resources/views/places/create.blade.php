@extends('layouts.app')

@section('contentheader_title', 'Create place')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li class="active">Creating</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        {!! Form::open(['route' => 'places.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('identifier', 'Identifier', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier', null, ['class' => 'form-control', 'placeholder' => 'Enter an identifier if one such is needed']) !!}
            </div>
          </div>          
          
          <div class="form-group">
            {!! Form::label('place_id', 'Parent Place', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('place_id', $places, null, ['class' => 'form-control']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('address', 'Address', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Enter address']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('zipcode', 'ZIP Code', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('zipcode', null, ['class' => 'form-control', 'placeholder' => 'Enter ZIP Code']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('city', 'City', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Enter city']) !!}
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('places.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection