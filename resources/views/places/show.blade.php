@extends('layouts.app')

@section('contentheader_title', $place->name)

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li class="active">{{ $place->name }}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        <div class="box-body">

          <div class="row">
            <div class="col-sm-6">
	            
	            
	            
			<div class="row">
	           <div class="col-sm-2">
              <strong>Name</strong>
            </div>
            <div class="col-sm-10">
              {{ $place->name }}
            </div>
          </div>

          <div class="row">
            <div class="col-sm-2">
              <strong>Address</strong>
            </div>
            <div class="col-sm-10">
              {{ $place->address }}
            </div>
          </div>

          <div class="row">
            <div class="col-sm-2">
              <strong>ZIP Code</strong>
            </div>
            <div class="col-sm-10">
              {{ $place->zipcode }}
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-2">
              <strong>City</strong>
            </div>
            <div class="col-sm-10">
              {{ $place->city }}
            </div>
          </div>

	            
	            
            </div>
            <div class="col-sm-6">
	            
          <div class="row">
            <div class="col-sm-4">
              <strong>Identifier</strong>
            </div>
            <div class="col-sm-8">
              {{ $place->identifier }}
            </div>
          </div>	   	            	            
	            
<div class="row">
	           <div class="col-sm-4">
              <strong>Parent Place</strong>
            </div>
            <div class="col-sm-8">
              {{ $place->parent_place }}
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <strong>Menu Order</strong>
            </div>
            <div class="col-sm-8">
              {{ $place->order }}
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <strong>Enable Positioning</strong>
            </div>
            <div class="col-sm-8">
              {{ $place->beacon_positioning_enabled }}
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-4">
              <strong>Enable Proximity</strong>
            </div>
            <div class="col-sm-8">
              {{ $place->beacon_proximity_enabled }}
            </div>
          </div>
              <div class="row">
                <div class="col-sm-4">
                  <strong>Activated</strong>
                </div>
                <div class="col-sm-8">
                  {{ $place->activated }}
                </div>
              </div>

          
	            
	            
            </div>            
          </div>  





          
          
        </div>
        <div class="box-footer">
          <a href="{{ route('places.edit', $place->id) }}" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Floors</h3>
          <div class="pull-right box-tools">
            <a href="{{ route('floors.create', $place->id) }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add floor</a>
          </div>
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Floor no.</th>
                  <th>Locations</th>
                  <th class="text-right"></th>
                </tr>
              @foreach($place->floors as $index => $floor)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('floors.show', [$place->id, $floor->id]) }}">{{ $floor->name }}</a></td>
                  <td>{{ $floor->order }}</td>
                  <td>{{ $floor->locations()->count() }}</td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['floors.destroy', $place->id, $floor->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('floors.edit', [$place->id, $floor->id]) }}" class="btn btn-info btn-sm">Edit</a>
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

<div class="row">
  <div class="col-sm-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Menu</h3>
        </div>
        <div class="box-body">
          <ul id="menu-list" class="todo-list ui-sortable">
          @foreach($menuitems as $item)
            <li id="menuitem-{{ $item->id }}">
              <span class="handle ui-sortable-handle">
                <i class="fa fa-ellipsis-v"></i>
                <i class="fa fa-ellipsis-v"></i>
              </span>
              @if($item->poi)
                <span class="text">{{ $item->poi->name }}</span>
              @elseif( $item->title )
                <span class="text"><big>- {{ $item->title }} -</big></span>
              @endif
              <div class="tools">
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
          @endforeach
          </ul>
        </div>
      </div>
  </div>
  <div class="col-sm-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add menu item</h3>
        </div>
        {!! Form::open(['route' => ['menu.store', $place->id], 'method' => 'POST']) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('type', 'Type') !!}
            {!! Form::select('type', ['poi' => 'POI', 'title' => 'Title'], null, ['class' => 'form-control', 'id' => 'menu-item-type']) !!}
          </div>
          <div class="form-group" id="poi-type">
            {!! Form::label('poi', 'POI') !!}
            {!! Form::select('poi', $pois, '', ['class' => 'form-control']) !!}
          </div>
          <div class="form-group" id="title-type" style="display: none">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-info pull-right">Add</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection

@section('footer')
<script>
// send csrf token in ajax header
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function(){
  $('#menu-item-type').change(function(){
    if ($(this).val() == 'title') {
      $('#title-type').show();
      $('#poi-type').hide();
    }
    else {
      $('#title-type').hide();
      $('#poi-type').show();
    }
  });

  $('#menu-list').sortable({
    placeholder: 'sort-highlight',
    handle: '.handle',
    containment: 'parent',
    forcePlaceholderSize: true,
    zIndex: 999999,
    update: function(event, ui){
      var sorted = $('#menu-list').sortable('serialize');

      $.ajax({
        type: 'POST',
        url: '{{ route('menu.update', $place->id) }}',
        data: sorted,
        success: function(){
          // show notification maybe?
        }
      });
    }
  });

  $('.tools .fa', $('#menu-list')).click(function(){
    var parent = $(this).closest('li');

    $.ajax({
      type: 'DELETE',
      url: '{{ route('menu.destroy', $place->id) }}',
      data: 'menuitem=' + parent.attr('id'),
      success: function(){
        // show notification maybe?
        parent.fadeOut();
      }.bind(this)
    });
  });
});
</script>
@endsection