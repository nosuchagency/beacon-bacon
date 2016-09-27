@extends('layouts.app')

@section('contentheader_title', 'Edit ' . $block->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('blocks.index') }}">Building Blocks</a></li>
  <li><a href="{{ route('blocks.show', $block->name) }}">{{ $block->name }}</a></li>
  <li class="active">Editing</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        {!! Form::open(['route' => ['blocks.update', $block->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', $block->name, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>


          <div id="icon_field_group" class="form-group">
            {!! Form::label('image', 'Image', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              @if($block->image)
                <img src="{{ $block->image }}" alt="" />
              @endif
              {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('blocks.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection