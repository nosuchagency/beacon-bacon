@extends('layouts.app')

@section('contentheader_title', 'Floors')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li><a href="{{ route('places.index') }}">{{__('Places')}}</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $place->name }}</a></li>
  <li class="active">{{__('Floors')}}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('Floor list')}}</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>{{__('Name')}}</th>
                  <th>{{__('Floor no.')}}</th>
                  <th class="text-right">{{__('Actions')}}</th>
                </tr>
              @foreach($floors as $index => $floor)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('floors.show', [$placeId, $floor->id]) }}">{{ $floor->name }}</a></td>
                  <td>{{ $floor->order }}</td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['floors.destroy', $placeId, $floor->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('floors.edit', [$placeId, $floor->id]) }}" class="btn btn-primary btn-sm">{{__('Edit')}}</a>
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