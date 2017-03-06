@extends('layouts.app')

@section('contentheader_title', 'Places')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li class="active">{{__('Places')}}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('Place list')}}</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">{{__('#')}}</th>
                  <th>{{__('Name')}}</th>
                  <th class="text-right">{{__('Actions')}}</th>
                </tr>
              @foreach($places as $index => $place)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('places.show', $place->id) }}">{{ $place->name }}</a></td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['places.destroy', $place->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="#" class="btn btn-primary btn-sm">{{__('Edit')}}</a>
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