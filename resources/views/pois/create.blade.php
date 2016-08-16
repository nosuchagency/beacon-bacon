@extends('layouts.app')

@section('contentheader_title', 'Create Point of Interest')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('pois.index') }}">Point of Interests</a></li>
  <li class="active">Create Point of Interest</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        {!! Form::open(['route' => 'pois.store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('internal_name', 'Internal name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('internal_name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('icon', 'Icon', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::file('icon', null, ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('pois.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection