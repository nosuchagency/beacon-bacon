@extends('layouts.auth')

@section('htmlheader_title')
    {{__('Team Capacity Reached')}}
@endsection

@section('content')
    <body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('home') }}"><b>{{__('Beacon')}}</b>{{__('Bacon')}}</a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <div class="panel-body">
                <h4>{{__('Team capacity reached')}}</h4>
                <p>{{__('You will need an invitation in order to register')}}</p>
                <p>{{__('If you are the system administrator, you can also raise the team limit')}}</p>
                <p>{{__('If you already have a profile, click the link below')}}</p>
                <a href="{{ url('/login') }}">{{__('Login')}}</a><br>
            </div>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    </body>
@endsection
