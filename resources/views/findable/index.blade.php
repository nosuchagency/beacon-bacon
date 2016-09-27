@extends('layouts.app')

@section('contentheader_title', 'Findables')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Findables</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">List</h3>
	      <div class="pull-right box-tools">
	        <a href="{{ route('findables.create') }}" class="btn btn-success btn-sm"><i class="fa fa-dot-circle-o"></i> Add Findable</a>
	      </div>          
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Internal name</th>
                  <th class="text-right"></th>
                </tr>
              @foreach($findables as $index => $findable)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('findables.edit', $findable->id) }}">{{ $findable->name }}</a></td>
                  <td>{{ $findable->internal_name }}</td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['findables.destroy', $findable->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('findables.edit', $findable->id) }}" class="btn btn-primary btn-sm">Edit</a>
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