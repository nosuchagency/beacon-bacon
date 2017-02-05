@extends('layouts.app')

@section('contentheader_title', $poi->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('pois.index') }}">Point of Interests</a></li>
  <li class="active">{{ $poi->name }}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">POI details</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $poi->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Internal name</strong>
            </div>
            <div class="col-sm-10">
              {{ $poi->internal_name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Icon</strong>
            </div>
            <div class="col-sm-10">
              @if($poi->icon)
                <img src="{{ $poi->getVirtualIconPath() }}" />
              @endif
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('pois.index') }}" class="btn btn-default">Back</a>
          <a href="{{ route('pois.edit', $poi->id) }}" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
  </div>
</div>
@endsection