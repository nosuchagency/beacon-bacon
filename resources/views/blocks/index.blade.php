@extends('layouts.app')

@section('contentheader_title', 'Building Blocks')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Building Blocks</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">List</h3>          
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th class="text-right"></th>
                </tr>
              @foreach($blocks as $index => $block)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('blocks.edit', $block->id) }}">{{ $block->name }}</a></td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['blocks.destroy', $block->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('blocks.edit', $block->id) }}" class="btn btn-primary btn-sm">Edit</a>
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