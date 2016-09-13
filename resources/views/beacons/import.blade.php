@extends('layouts.app')

@section('contentheader_title', 'Import beacons')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('beacons.index') }}">Beacons</a></li>
  <li class="active">Import Settings</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Import Settings</h3>
        </div>
        {!! Form::open(['route' => 'beacons.importing', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('beacon-import-service', 'Service', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('beacon-import-service', $services, config('beacon.import.service'), ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('beacon-import-username', 'Username', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('beacon-import-username', config('beacon.import.username'), ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('beacon-import-password', 'Password', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('beacon-import-password', config('beacon.import.password'), ['class' => 'form-control']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('beacon-import-apikey', 'API Key', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('beacon-import-apikey', config('beacon.import.apikey'), ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('beacon-import-apisecret', 'API Secret', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('beacon-import-apisecret', config('beacon.import.apisecret'), ['class' => 'form-control']) !!}
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('beacons.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection

@section('footer')
<script>

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