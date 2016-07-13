@extends('layouts.app')

@section('contentheader_title', $category->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('categories.index') }}">Categories</a></li>
  <li class="active">{{ $category->name }}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Category details</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $category->name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Internal name</strong>
            </div>
            <div class="col-sm-10">
              {{ $category->internal_name }}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <strong>Icon</strong>
            </div>
            <div class="col-sm-10">
              @if($category->icon)
                <img src="{{ asset('uploads/categories/' . $category->id . '/' . $category->icon) }}" />
              @endif
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('categories.index') }}" class="btn btn-default">Back</a>
          <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
  </div>
</div>
@endsection