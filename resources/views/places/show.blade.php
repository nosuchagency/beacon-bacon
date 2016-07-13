@extends('layouts.app')

@section('contentheader_title', $place->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li class="active">{{ $place->name }}</li>
</ol>
@endsection

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

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Floor list</h3>
          <div class="pull-right box-tools">
            <a href="{{ route('maps.create', $place->id) }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add floor</a>
          </div>
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Floor no.</th>
                  <th class="text-right">Actions</th>
                </tr>
              @foreach($place->maps as $index => $map)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('maps.show', [$place->id, $map->id]) }}">{{ $map->name }}</a></td>
                  <td>{{ $map->order }}</td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['maps.destroy', $place->id, $map->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('maps.edit', [$place->id, $map->id]) }}" class="btn btn-info btn-sm">Edit</a>
                    {!! Form::close() !!}
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
        </div>
      </div>
  </div>
</div>
@endsection