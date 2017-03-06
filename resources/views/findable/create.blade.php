@extends('layouts.app')

@section('contentheader_title', 'Create Findable')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
        <li><a href="{{ route('pois.index') }}">{{__('Findables')}}</a></li>
        <li class="active">{{__('Creating')}}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Details')}}</h3>
                </div>
                {!! Form::open(['route' => 'findables.store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="box-body">

                    <div class="form-group">
                        {!! Form::label('name', __('Name'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter name')]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('identifier', __('Identifier'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::text('identifier', null, ['class' => 'form-control', 'placeholder' => __('Enter identifier')]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('parameter_one_name', __('Parameter One Name'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::text('parameter_one_name', null, ['class' => 'form-control', 'placeholder' => __('Enter parameter one name')]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('parameter_two_name', __('Parameter Two Name'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::text('parameter_two_name', null, ['class' => 'form-control', 'placeholder' => __('Enter parameter two name')]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('parameter_three_name', __('Parameter Three Name'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::text('parameter_three_name', null, ['class' => 'form-control', 'placeholder' => __('Enter parameter three name')]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('parameter_four_name', __('Parameter Four Name'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::text('parameter_four_name', null, ['class' => 'form-control', 'placeholder' => __('Enter parameter four name')]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('parameter_five_name', __('Parameter Five Name'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::text('parameter_five_name', null, ['class' => 'form-control', 'placeholder' => __('Enter parameter five name')]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('custom_file', __('Custom Findable File'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::file('custom_file', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <a href="{{ route('findables.index') }}" class="btn btn-default">{{__('Cancel')}}</a>
                    <button type="submit" class="btn btn-info pull-right">{{__('Save')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>

        var dirty = false;
        $(document).ready(function () {

            $('#identifier').focus(function () {
                dirty = true;
            });

            $('#name').keyup(function () {
                if (dirty == false) {
                    $('#identifier').val($('#name').val());
                }
            });

        });

    </script>
@endsection