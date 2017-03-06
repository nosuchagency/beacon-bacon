@extends('layouts.app')

@section('htmlheader_title')
    {{__('Page not found')}}
@endsection

@section('contentheader_title')
    {{__('404 Error Page')}}
@endsection

@section('contentheader_description')
@endsection

@section('content')

<div class="error-page">
    <h2 class="headline text-yellow"> {{__('404')}}</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> {{__('Oops! Page not found.')}}</h3>
        <p>
            {{__('We could not find the page you were looking for.')}}
            {{__('Meanwhile, you may')}} <a href='{{ route('home') }}'>{{__('return to dashboard')}}</a> {{__('or try using the search form.')}}
        </p>
        <form class='search-form'>
            <div class='input-group'>
                <input type="text" name="search" class='form-control' placeholder="Search"/>
                <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                </div>
            </div><!-- /.input-group -->
        </form>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
@endsection