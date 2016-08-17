@extends('layouts.app')

@section('contentheader_title', 'Create new beacon')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('beacons.index') }}">Beacons</a></li>
  <li class="active">Create beacon</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Beacon details</h3>
        </div>
        {!! Form::open(['route' => 'beacons.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('beacon_uid', 'Beacon', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('beacon_uid', $devices->sort()->prepend('Select beacon', ''), (isset($beacon) ? $beacon->uniqueId : null), ['class' => 'form-control', 'id' => 'select-beacon']) !!}
            </div>
          </div>
          @if(isset($beacon))
          <div class="form-group">
            {!! Form::label('proximity_uuid', 'Proximity UUID', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('proximity_uuid', $beacon->proximity, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('major', 'Major', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('major', $beacon->major, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('minor', 'Minor', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('minor', $beacon->minor, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('place_id', 'Place', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('place_id', $places, null, ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('floor_id', 'Floor', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('floor_id', $floors, null, ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter description']) !!}
            </div>
          </div>
          @endif
        </div>
        <div class="box-footer">
          <a href="{{ route('beacons.index') }}" class="btn btn-default">Cancel</a>
          @if(isset($beacon))
          <button type="submit" class="btn btn-info pull-right">Save</button>
          @endif
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection

@section('footer')
<script>
$(document).ready(function(){
  $('#select-beacon').change(function(){
    top.location.href = '{{ route('beacons.create') }}?beacon_uid=' + $(this).val();
  });
});
</script>
@endsection