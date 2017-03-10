@extends('layouts.app')

@section('contentheader_title', 'Edit ' . $place->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li><a href="{{ route('places.index') }}">{{__('Places')}}</a></li>
  <li><a href="{{ route('places.show', $place->id) }}">{{ $place->name }}</a></li>
  <li class="active">{{__('Edit place')}}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('Place details')}}</h3>
        </div>
        {!! Form::open(['route' => ['places.update', $place->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          
          <div class="form-group">
            {!! Form::label('name', __('Name'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', $place->name, ['class' => 'form-control', 'placeholder' => __('Enter name')]) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('address', __('Address'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('address', $place->address, ['class' => 'form-control', 'placeholder' => __('Enter address')]) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('zipcode', __('ZIP Code'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('zipcode', $place->zipcode, ['class' => 'form-control', 'placeholder' => __('Enter ZIP Code')]) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('city', __('City'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('city', $place->city, ['class' => 'form-control', 'placeholder' => __('Enter city')]) !!}
            </div>
          </div>
          
          
          
          
          <div class="form-group">
			<h5 class="col-sm-2" style="font-size: 16px; text-align: right;">{{__('System')}}</h5>
            <div class="col-sm-10"></div>
          </div>          
          
          <div class="form-group">
            {!! Form::label('identifier_one', __('Identifier 1'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_one', $place->identifier_one, ['class' => 'form-control', 'placeholder' => __('Enter an identifier if one such is needed')]) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('identifier_two', __('Identifier 2'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_two', $place->identifier_two, ['class' => 'form-control', 'placeholder' => __('Enter an identifier if one such is needed')]) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('identifier_three', __('Identifier 3'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_three', $place->identifier_three, ['class' => 'form-control', 'placeholder' => __('Enter an identifier if one such is needed')]) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('identifier_four', __('Identifier 4'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_four', $place->identifier_four, ['class' => 'form-control', 'placeholder' => __('Enter an identifier if one such is needed')]) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('identifier_five', __('Identifier 5'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier_five', $place->identifier_five, ['class' => 'form-control', 'placeholder' => __('Enter an identifier if one such is needed')]) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('place_id', __('Parent Place'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('place_id', $places, $place->place_id, ['class' => 'form-control']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('order', __('Menu Order'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('order', $place->order, ['class' => 'form-control', 'placeholder' => __('Enter the menu order of this place')]) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('beacon_positioning_enabled', __('Enable Positioning'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::hidden('beacon_positioning_enabled', 0) !!}
              {!! Form::checkbox('beacon_positioning_enabled', 1, $place->beacon_positioning_enabled) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('beacon_proximity_enabled', __('Enable Proximity'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::hidden('beacon_proximity_enabled', 0) !!}
              {!! Form::checkbox('beacon_proximity_enabled', 1, $place->beacon_proximity_enabled) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('activated', __('Activated'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::hidden('activated', 0) !!}
              {!! Form::checkbox('activated', 1, $place->activated) !!}
            </div>
          </div>




        </div>
        <div class="box-footer">
          <a href="{{ route('places.show', $place->id) }}" class="btn btn-default">{{__('Cancel')}}</a>
          <button type="submit" class="btn btn-info pull-right">{{__('Save')}}</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection