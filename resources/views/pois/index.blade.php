@extends('layouts.app')

@section('contentheader_title', 'Point of Interests')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li class="active">{{__('Point of Interests')}}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('List')}}</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>{{__('Name')}}</th>
                  <th>{{__('Internal name')}}</th>
                  <th>{{__('Type')}}</th>
                  <th>{{__('Color')}}</th>
                  <th class="text-right"></th>
                </tr>
              @foreach($pois as $index => $poi)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('pois.edit', $poi->id) }}">{{ $poi->name }}</a></td>
                  <td>{{ $poi->internal_name }}</td>
                  <td>{{ $poi->type or 'Icon' }}</td>
                  <td>{{ $poi->color or 'n/a' }}</td>                                    
                  <td class="text-right">
                    {!! Form::open(['route' => ['pois.destroy', $poi->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('pois.edit', $poi->id) }}" class="btn btn-primary btn-sm">{{__('Edit')}}</a>
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