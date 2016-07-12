@extends('layouts.app')

@section('contentheader_title', 'Places')

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Place list</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th class="text-right">Actions</th>
                </tr>
              @foreach($places as $index => $place)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('places.show', $place->id) }}">{{ $place->name }}</a></td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['places.destroy', $place->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
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