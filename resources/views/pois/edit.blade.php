@extends('layouts.app')

@section('contentheader_title', 'Edit ' . $poi->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('pois.index') }}">Point of Interests</a></li>
  <li><a href="{{ route('pois.show', $poi->name) }}">{{ $poi->name }}</a></li>
  <li class="active">Editing</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        {!! Form::open(['route' => ['pois.update', $poi->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', $poi->name, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('internal_name', 'Internal name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('internal_name', $poi->internal_name, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('type', 'Type', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('type', $types, $poi->type, ['class' => 'form-control']) !!}
            </div>
          </div>

          <div id="icon_field_group" class="form-group">
            {!! Form::label('icon', 'Icon', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              @if($poi->icon)
                <img src="{{ $poi->icon }}" alt="" />
              @endif
              {!! Form::file('icon', null, ['class' => 'form-control']) !!}
            </div>
          </div>
          
          <div id="color_field_group" class="form-group">
            {!! Form::label('color', 'Color', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('color', $poi->color, ['class' => 'form-control', 'placeholder' => 'Enter area color in hex - fx. #ff0000']) !!}
            </div>
          </div>
          
        </div>
        <div class="box-footer">
          <a href="{{ route('pois.index') }}" class="btn btn-default">Cancel</a>
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
	
	if ( $( this ).val() == 'icon' ) {
		$( '#color_field_group' ).hide();		
	} else {
		$( '#icon_field_group' ).hide();
	}

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