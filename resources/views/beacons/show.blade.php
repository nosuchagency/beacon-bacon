@extends('layouts.app')

@section('contentheader_title', $beacon->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li><a href="{{ route('beacons.index') }}">{{__('Beacons')}}</a></li>
  <li class="active">{{ $beacon->name }}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('Beacon Details')}}</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>{{__('Beacon ID')}}</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->beacon_uid }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>{{__('Proximity UUID')}}</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->proximity_uuid }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>{{__('Major')}}</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->major }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>{{__('Minor')}}</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->minor }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>{{__('Place')}}</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->place->name or __('Not assigned') }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Floor</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->floor->name or __('Not assigned') }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>{{__('Name')}}</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>{{__('Description')}}</strong>
            </div>
            <div class="col-sm-10">
              {{ $beacon->description }}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('beacons.index') }}" class="btn btn-default">{{__('Back')}}</a>
          <a href="{{ route('beacons.edit', $beacon->id) }}" class="btn btn-info pull-right">{{__('Edit')}}</a>
        </div>
      </div>
  </div>
</div>
@endsection