@extends('layouts.app')

@section('contentheader_title', $beacon->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('beacons.index') }}">Beacons</a></li>
  <li class="active">{{ $beacon->name }}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Beacon details</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>Beacon ID</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->beacon_uid }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Proximity UUID</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->proximity_uuid }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Major</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->major }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Minor</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->minor }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Place</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->place->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Floor</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->map->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Description</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->description }}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('beacons.index') }}" class="btn btn-default">Back</a>
          <a href="{{ route('beacons.edit', $beacon->id) }}" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
  </div>
</div>
@endsection