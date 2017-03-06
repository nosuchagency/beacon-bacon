@extends('layouts.app')

@section('contentheader_title', 'Editing ' . $location->name)

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
        <li><a href="{{ route('places.index') }}">{{__('Places')}}</a></li>
        <li><a href="{{ route('places.show', $placeId) }}">{{ $location->place->name }}</a></li>
        <li><a href="{{ route('floors.show', [$placeId, $floorId]) }}">{{ $location->floor->name }}</a></li>
        <li><a href="{{ route('locations.show', [$placeId, $floorId, $location->id]) }}">{{ $location->name }}</a></li>
        <li class="active">{{__('Editing')}}</li>
    </ol>
@endsection

@section('content')

    {!! Form::open(['route' => ['locations.update', $placeId, $floorId, $location->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('place_id', $placeId) !!}
    {!! Form::hidden('floor_id', $floorId) !!}
    {!! Form::hidden('type', 'findable') !!}

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Details')}}</h3>
                </div>
                <div class="box-body">

                    <div class="form-group">
                        {!! Form::label('findable_id', 'Type', ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::select('findable_id', $findables, $location->findable->id, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('name', __('Name'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::text('name', $location->name, ['class' => 'form-control', 'placeholder' => __('Enter name')]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="col-sm-2" style="font-size: 16px; text-align: right;">{{__('Parameters')}}</h5>
                        <div class="col-sm-10"></div>
                    </div>

                    @if($location->findable->parameter_one_name)
                        <div class="form-group">
                            {!! Form::label('parameter_one', $location->findable->parameter_one_name, ['class' => 'col-sm-2 control-label']) !!}

                            <div class="col-sm-10">
                                {!! Form::text('parameter_one', $location->parameter_one, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_one_name]) !!}
                            </div>
                        </div>
                    @endif

                    @if($location->findable->parameter_two_name)
                        <div class="form-group">
                            {!! Form::label('parameter_two', $location->findable->parameter_two_name, ['class' => 'col-sm-2 control-label']) !!}

                            <div class="col-sm-10">
                                {!! Form::text('parameter_two', $location->parameter_two, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_two_name]) !!}
                            </div>
                        </div>
                    @endif

                    @if($location->findable->parameter_three_name)
                        <div class="form-group">
                            {!! Form::label('parameter_three', $location->findable->parameter_three_name, ['class' => 'col-sm-2 control-label']) !!}

                            <div class="col-sm-10">
                                {!! Form::text('parameter_three', $location->parameter_three, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_three_name]) !!}
                            </div>
                        </div>
                    @endif

                    @if($location->findable->parameter_four_name)
                        <div class="form-group">
                            {!! Form::label('parameter_four', $location->findable->parameter_four_name, ['class' => 'col-sm-2 control-label']) !!}

                            <div class="col-sm-10">
                                {!! Form::text('parameter_four', $location->parameter_four, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_four_name]) !!}
                            </div>
                        </div>
                    @endif

                    @if($location->findable->parameter_five_name)
                        <div class="form-group">
                            {!! Form::label('parameter_five', $location->findable->parameter_five_name, ['class' => 'col-sm-2 control-label']) !!}

                            <div class="col-sm-10">
                                {!! Form::text('parameter_five', $location->parameter_five, ['class' => 'form-control', 'placeholder' => __('Enter ') . $location->findable->parameter_five_name]) !!}
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <h5 class="col-sm-2" style="font-size: 16px; text-align: right;">{{__('Location on Map')}}</h5>
                        <div class="col-sm-10"></div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('area', __('Area'), ['class' => 'col-sm-2 control-label']) !!}

                        <div class="col-sm-10">
                            {!! Form::text('area', $location->area, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="col-sm-2" style="font-size: 16px; text-align: right;">{{__('Draw Findable on Map')}}</h5>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-info pull-right" id="canvas_reset_button">{{__('Start Over')}}
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2"></div>

                        <div class="col-sm-10">

                            <div id="floor-map-container" style="overflow: scroll; width: 100%;">
                                <canvas id="floor-map" height="{{ $location->mapHeight }}"
                                        width="{{ $location->mapWidth }}"
                                        style="background-image: url({{ $location->floor->getVirtualIconPath() }}?random={{ str_random(60) }}); cursor: crosshair;"></canvas>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <a href="{{ route('floors.show', [$placeId, $floorId]) }}" class="btn btn-default">{{__('Cancel')}}</a>
                    <button type="submit" class="btn btn-info pull-right">{{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('footer')
    <script>

        var MAP_WIDTH = {{ $location->mapWidth }};
        var MAP_HEIGHT = {{ $location->mapHeight }};

        var MAP_WIDTH_CENTIMETERS = {{ $location->mapWidthCentimeters }};
        var MAP_HEIGHT_CENTIMETERS = {{ $location->mapHeightCentimeters }};

        var AREA_COLOR = '#f4f142';

        function hexToRgb(hex) {
            var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
            hex = hex.replace(shorthandRegex, function (m, r, g, b) {
                return r + r + g + g + b + b;
            });

            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                    r: parseInt(result[1], 16),
                    g: parseInt(result[2], 16),
                    b: parseInt(result[3], 16)
                } : null;
        }

        function floor_map() {
            var floor_map_width = $('#floor-map-container').width();

            ratio = floor_map_width / MAP_WIDTH;
            var floor_map_height = Math.round(MAP_HEIGHT * ratio);

            $('#floor-map-container').css('height', floor_map_height + 'px');
        }

        $(window).resize(function () {
            floor_map();
        });

        $(document).ready(function () {

            $('#floor-map').canvasAreaDraw({
                'input': '#area',
                'rgb': hexToRgb(AREA_COLOR),
                'reset': '#canvas_reset_button'
            });

        });
    </script>
@endsection