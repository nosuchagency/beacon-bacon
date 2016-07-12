@extends('layouts.app')

@section('contentheader_title', 'Floors')

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Floor list</h3>
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
              @foreach($maps as $index => $map)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('maps.show', $map->id) }}">{{ $map->name }}</a></td>
                  <td>{{ $map->order }}</td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['maps.destroy', $map->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('maps.edit', $map->id) }}" class="btn btn-primary btn-sm">Edit</a>
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