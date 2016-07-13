@extends('layouts.app')

@section('contentheader_title', 'Edit ' . $category->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('categories.index') }}">Categories</a></li>
  <li><a href="{{ route('categories.show', $category->name) }}">{{ $category->name }}</a></li>
  <li class="active">Edit category</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Category details</h3>
        </div>
        {!! Form::open(['route' => ['categories.update', $category->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', $category->name, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('internal_name', 'Internal name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('internal_name', $category->internal_name, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('icon', 'Icon', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              @if($category->icon)
                <img src="{{ asset('uploads/categories/' . $category->id . '/' . $category->icon) }}" />
              @endif
              {!! Form::file('icon', null, ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="{{ route('categories.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection