@extends('layouts.app')

@section('contentheader_title', 'Profile')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Profile</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Profile details</h3>
        </div>
        {!! Form::open(['route' => ['profile.update'], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Enter your name']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('email', 'E-mail', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Enter your email']) !!}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Change password</h3>
        </div>
        {!! Form::open(['route' => ['profile.password'], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('old_password', 'Old password', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::password('old_password', ['class' => 'form-control', 'placeholder' => '']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('password', 'New password', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('password_confirmation', 'Re-type password', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => '']) !!}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-info pull-right">Update password</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection