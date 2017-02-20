@extends('layouts.auth')

@section('htmlheader_title')
    Team Capacity Reached
@endsection

@section('content')
    <body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('home') }}"><b>Beacon</b>Bacon</a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <div class="panel-body">
                <h4>Team capacity reached</h4>
                <p>You will need an invitation in order to register</p>
                <p>If you are the system administrator, you can also raise the team limit</p>
                <p>If you already have a profile, click the link below</p>
                <a href="{{ url('/login') }}">Log in</a><br>
            </div>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    </body>
@endsection
