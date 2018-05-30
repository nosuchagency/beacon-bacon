@extends('layouts.auth')

@section('htmlheader_title')
    {{__('Login')}}
@endsection
@section('content')
    <body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('home') }}"><b>{{__('Wayfinder')}}</b>{{__('Admin')}}</a>
        </div><!-- /.login-logo -->
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>{{__('Whoops!')}}</strong> {{__('There were some problems with your input.')}}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login-box-body">
            @if(session()->has('invite_token'))
                <p class="login-box-msg">{{__('Sign in to accept the invitation')}}</p>
            @else
                <p class="login-box-msg">{{__('Sign in to start your session')}}</p>
            @endif
            <form action="{{ url('/login') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember"> {{__('Remember me')}}
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{__('Sign in')}}</button>
                    </div><!-- /.col -->
                </div>
            </form>

            {{-- @include('auth.partials.social_login') --}}
            <a href="{{ url('/password/reset') }}">{{__('I forgot my password')}}</a><br>
            @if (!empty($allowTeam) && $allowTeam)
                <a href="{{ url('/register') }}" class="text-center">{{__('Register a new account')}}</a>
            @endif
        </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->

    @include('layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    </body>

@endsection
