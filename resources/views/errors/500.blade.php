@extends('layouts.app')

@section('htmlheader_title')
    {{__('Server Error')}}
@endsection

@section('contentheader_title')
    {{__('500 Error page')}}
@endsection

@section('contentheader_description')
@endsection

@section('content')

    <div class="error-page">
        <h2 class="headline text-red">{{__('500')}}</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i>{{__('Oops! Something went wrong.')}}</h3>
            <p>
                {{__('We will work on fixing that right away.')}}
                {{__('Meanwhile, you may')}} <a href='{{ route('home') }}'>{{__('return to dashboard')}}</a> {{__('or try using the search form.')}}
            </p>
            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="Search"/>
                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                    </div>
                </div><!-- /.input-group -->
            </form>
        </div>
    </div><!-- /.error-page -->
@endsection