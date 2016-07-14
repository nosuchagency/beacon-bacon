@extends('layouts.app')

@section('contentheader_title', 'Templates')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Settings</li>
  <li class="active">Templates</li>
</ol>
@endsection

@section('content')
{!! Form::open(['route' => ['settings.templates.update'], 'method' => 'PUT']) !!}
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Reset password</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('mail-templates-reset-subject', 'Subject', ['class' => 'control-label']) !!}
            {!! Form::text('mail-templates-reset-subject', config('mail.templates.reset.subject'), ['class' => 'form-control', 'placeholder' => 'Your Password Reset Link']) !!}
          </div>
          <div class="form-group">
            <textarea name="mail-templates-reset-body" class="textarea" id="some-textarea" placeholder="Click here to reset your password: @{{ link }}" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
              {{ config('mail.templates.reset.body') }}
            </textarea>
            <p>
              Use the placeholder <code>@{{ link }}</code> to insert the reset link.
            </p>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
      </div>
  </div>
</div>
{!! Form::close() !!}
@endsection

@section('header')
<link href="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer')
<script src="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script type="text/javascript">
    $('#some-textarea').wysihtml5();
</script>
@endsection