@extends('layouts.app')

@section('contentheader_title', $map->name)

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Floor details</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>Place</strong>
            </div>
            <div class="col-sm-10">
              {{ $map->place->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $map->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Floor no.</strong>
            </div>
            <div class="col-sm-10">
              {{ $map->order }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Image</strong>
            </div>
            <div class="col-sm-10">
              @if($map->image)
                <img src="{{ asset('uploads/maps/' . $map->id . '/' . $map->image) }}" />
              @endif
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('maps.index') }}" class="btn btn-default">Back</a>
          <a href="{{ route('maps.edit', $map->id) }}" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
  </div>
</div>
@endsection