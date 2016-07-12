@extends('layouts.app')

@section('contentheader_title', 'Create new place')

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Place details</h3>
        </div>
        {!! Form::open(['route' => 'places.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
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