@extends('layouts.app')

@section('contentheader_title', $location->name)

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Location details</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>Place</strong>
            </div>
            <div class="col-sm-10">
              {{ $location->place->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Floor</strong>
            </div>
            <div class="col-sm-10">
              {{ $location->map->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Category</strong>
            </div>
            <div class="col-sm-10">
              {{ $location->category->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $location->name }}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('locations.index') }}" class="btn btn-default">Back</a>
          <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
  </div>
</div>
@endsection