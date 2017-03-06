@extends('layouts.app')

@section('contentheader_title', 'Create Building Block Location')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li><a href="{{ route('places.index') }}">{{__('Places')}}</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $place->name }}</a></li>
  <li><a href="{{ route('floors.show', [$placeId, $floorId]) }}">{{ $floor->name }}</a></li>
  <li class="active">{{__('Creating Building Block')}}</li>
</ol>
@endsection

@section('content')
{!! Form::open(['route' => ['locations.store', $placeId, $floorId], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
{!! Form::hidden('place_id', $placeId) !!}
{!! Form::hidden('floor_id', $floorId) !!}
{!! Form::hidden('type', 'block') !!}

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('Details')}}</h3>
        </div>
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('block_id', __('Building Block'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('block_id', $blocks, null, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('findable_id', __('Type'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('findable_id', $findables, null, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('name', __('Name'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter name')]) !!}
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('floors.show', [$placeId, $floorId]) }}" class="btn btn-default">{{__('Name')}}</a>
          <button type="submit" class="btn btn-info pull-right">{{__('Save')}}</button>
        </div>
      </div>
  </div>
</div>
{!! Form::close() !!}
@endsection

@section('footer')
<script>

var dirty = false;
$( document ).ready( function ( ) {

	$( '#name' ).focus( function () {
		dirty = true;
	} );
	
	$( '#poi_id' ).change( function () {
		if ( dirty == false ) {
			$( '#name' ).val( $( '#poi_id option:selected' ).text() );
		}
	} );

} );

</script>	
@endsection