@extends('layouts.app')

@section('contentheader_title', $place->name)

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Place details</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $place->name }}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('places.index') }}" class="btn btn-default">Back</a>
          <a href="{{ route('places.edit', $place->id) }}" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
  </div>
</div>
@endsection