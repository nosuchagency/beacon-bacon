@extends('layouts.app')

@section('contentheader_title', 'Locations')

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Location list</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Place</th>
                  <th>Floor</th>
                  <th>Category</th>
                  <th class="text-right">Actions</th>
                </tr>
              @foreach($locations as $index => $location)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('locations.show', $location->id) }}">{{ $location->name }}</a></td>
                  <td>{{ $location->place->name }}</td>
                  <td>{{ $location->map->name }}</td>
                  <td>{{ $location->category->name }}</td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['locations.destroy', $location->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-primary btn-sm">Edit</a>
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