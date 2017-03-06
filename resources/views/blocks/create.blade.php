@extends('layouts.app')

@section('contentheader_title', 'Create Building Block')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li><a href="{{ route('blocks.index') }}">{{__('Building Blocks')}}</a></li>
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
        {!! Form::open(['route' => 'blocks.store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('name', __('Name'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter name')]) !!}
            </div>
          </div>

          <div id="icon_field_group" class="form-group">
            {!! Form::label('image', __('Image'), ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('blocks.index') }}" class="btn btn-default">{{__('Cancel')}}</a>
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
	$( '#color_field_group' ).hide();

	$( '#internal_name' ).focus( function () {
		dirty = true;
	} );
	
	$( '#name' ).keyup( function () {
		if ( dirty == false ) {
			$( '#internal_name' ).val( $( '#name' ).val() );
		}
	} );
	
	$( '#type' ).change( function () {
		var type = $( this ).val();
		
		switch ( type ) {
			case 'icon' :
				$( '#icon_field_group' ).show();
				$( '#color_field_group' ).hide();
				break;
				
			case 'area' :
				$( '#color_field_group' ).show();
				$( '#icon_field_group' ).hide();
				break;
		}

	} );

} );

</script>	
@endsection