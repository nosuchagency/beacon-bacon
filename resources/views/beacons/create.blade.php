@extends('layouts.app')

@section('contentheader_title', 'Create beacon')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li><a href="{{ route('beacons.index') }}">{{__('Beacons')}}</a></li>
  <li class="active">{{__('Creating')}}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('Details')}}</h3>
        </div>
        {!! Form::open(['route' => 'beacons.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('beacon_uid', __('Beacon UID'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('beacon_uid', null, ['class' => 'form-control']) !!}              
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('proximity_uuid', __('Proximity UUID'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('proximity_uuid', null, ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('major', __('Major'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('major', null, ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('minor', __('Minor'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('minor', null, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('name', __('Name'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter name')]) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('description', __('Description'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter description')]) !!}
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('beacons.index') }}" class="btn btn-default">{{__('Cancel')}}</a>
          <button type="submit" class="btn btn-info pull-right">{{__('Save')}}</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection

@section('footer')
<script>

var dirty = false;
$( document ).ready( function ( ) {

	$( '#name' ).focus( function () {
		dirty = true;
	} );
	
	$( '#beacon_uid' ).keyup( function () {
		if ( dirty == false ) {
			$( '#name' ).val( $( '#beacon_uid' ).val() );
		}
	} );

} );

</script>	
@endsection