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
          
          <div class="form-group">
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">System</h5>
            <div class="col-sm-10"></div>
          </div>          
          
          <div class="form-group">
            {!! Form::label('identifier_one', 'Identifier 1', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_one', null, ['class' => 'form-control', 'placeholder' => 'Enter an identifier if one such is needed']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('identifier_two', 'Identifier 2', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_two', null, ['class' => 'form-control', 'placeholder' => 'Enter an identifier if one such is needed']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('identifier_three', 'Identifier 3', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_three', null, ['class' => 'form-control', 'placeholder' => 'Enter an identifier if one such is needed']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('identifier_four', 'Identifier 4', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_four', null, ['class' => 'form-control', 'placeholder' => 'Enter an identifier if one such is needed']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('identifier_five', 'Identifier 5', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_five', null, ['class' => 'form-control', 'placeholder' => 'Enter an identifier if one such is needed']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('place_id', 'Parent Place', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('place_id', $places, null, ['class' => 'form-control']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('order', 'Menu Order', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('order', null, ['class' => 'form-control', 'placeholder' => 'Enter the menu order of this place']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('beacon_positioning_enabled', 'Enable Positioning', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::checkbox('beacon_positioning_enabled', 1, false) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('beacon_proximity_enabled', 'Enable Proximity', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::checkbox('beacon_proximity_enabled', 1, false) !!}
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