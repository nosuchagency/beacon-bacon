@extends('layouts.app')

@section('contentheader_title', 'Email settings')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Settings</li>
  <li class="active">Email</li>
</ol>
@endsection

@section('content')
{!! Form::open(['route' => ['settings.email.update'], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">E-mail provider</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('name', 'Provider', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::select('mail-driver', $mailProviders, config('mail.driver'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('mail-from-name', 'Sender name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('mail-from-name', config('mail.from.name'), ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('mail-from-address', 'Sender email', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::email('mail-from-address', config('mail.from.address'), ['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="{{ config('mail.driver') == 'smtp' ? 'active' : '' }}"><a href="#tab_1" data-toggle="tab">SMTP</a></li>
        <li class="{{ config('mail.driver') == 'mailgun' ? 'active' : '' }}"><a href="#tab_2" data-toggle="tab">Mailgun</a></li>
        <li class="{{ config('mail.driver') == 'mandrill' ? 'active' : '' }}"><a href="#tab_3" data-toggle="tab">Mandrill</a></li>
        <li class="{{ config('mail.driver') == 'ses' ? 'active' : '' }}"><a href="#tab_4" data-toggle="tab">SES</a></li>
        <li class="{{ config('mail.driver') == 'sparkpost' ? 'active' : '' }}"><a href="#tab_5" data-toggle="tab">Sparkpost</a></li>
      </ul>
      <div class="tab-content">
        <!-- SMTP -->
        <div class="tab-pane {{ config('mail.driver') == 'smtp' ? 'active' : '' }}" id="tab_1">
          <div class="form-group">
            {!! Form::label('mail-host', 'Host', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('mail-host', config('mail.host'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('mail-port', 'Port', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('mail-port', config('mail.port'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('mail-encryption', 'Encryption', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('mail-encryption', config('mail.encryption'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('mail-username', 'Username', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('mail-username', config('mail.username'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('mail-password', 'Password', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('mail-password', config('mail.password'), ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <!-- Mailgun -->
        <div class="tab-pane {{ config('mail.driver') == 'mailgun' ? 'active' : '' }}" id="tab_2">
          <div class="form-group">
            {!! Form::label('services-mailgun-domain', 'Domain', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('services-mailgun-domain', config('services.mailgun.domain'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('services-mailgun-secret', 'Secret', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('services-mailgun-secret', config('services.mailgun.secret'), ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <!-- Mandrill -->
        <div class="tab-pane {{ config('mail.driver') == 'mandrill' ? 'active' : '' }}" id="tab_3">
          <div class="form-group">
            {!! Form::label('services-mandrill-secret', 'Secret', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('services-mandrill-secret', config('services.mandrill.secret'), ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <!-- SES -->
        <div class="tab-pane {{ config('mail.driver') == 'ses' ? 'active' : '' }}" id="tab_4">
          <div class="form-group">
            {!! Form::label('services-ses-key', 'Key', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('services-ses-key', config('services.ses.key'), ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('services-ses-secret', 'Secret', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('services-ses-secret', config('services.ses.secret'), ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <!-- Mandrill -->
        <div class="tab-pane {{ config('mail.driver') == 'sparkpost' ? 'active' : '' }}" id="tab_5">
          <div class="form-group">
            {!! Form::label('services-sparkpost-secret', 'Secret', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('services-sparkpost-secret', config('services.sparkpost.secret'), ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}
@endsection