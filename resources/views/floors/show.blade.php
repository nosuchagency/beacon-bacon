@extends('layouts.app')

@section('contentheader_title', $floor->name)

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
        <li><a href="{{ route('places.index') }}">{{__('Places')}}</a></li>
        <li><a href="{{ route('places.show', $floor->place_id) }}">{{ $floor->place->name }}</a></li>
        <li class="active">{{ $floor->name }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Details')}}</h3>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-2">
                                    <strong>{{__('Place')}}</strong>
                                </div>
                                <div class="col-sm-10">
                                    {{ $floor->place->name }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <strong>{{__('Name')}}</strong>
                                </div>
                                <div class="col-sm-10">
                                    {{ $floor->name }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <strong>{{__('Floor no.')}}</strong>
                                </div>
                                <div class="col-sm-10">
                                    {{ $floor->order }}
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">

                            <table style="height: 400px; width: 400px;">
                                <tr style="height: 20px;">
                                    <td style="width: 40px;"></td>
                                    <td style="text-align: center; width: 320px;">
                                        {{ $floor->map_width_in_centimeters }}{{__('cm')}}
                                    </td>
                                    <td style="width: 40px;"></td>
                                </tr>
                                <tr style="height: 360px;">
                                    <td style="width: 40px;">
                                        {{ $floor->map_height_in_centimeters }}{{__('cm')}}
                                    </td>
                                    <td style="width: 320px;">
                                        <div style="background-image: url({{ $floor->getVirtualIconPath() }}?random={{ str_random(60) }}); background-position: center center; background-repeat: no-repeat; background-size: contain; border: 1px solid #333; height: 360px; line-height: 360px; text-align: center; width: 320px;">
                                            {{ $floor->map_pixel_to_centimeter_ratio }} {{__('ratio')}}
                                        </div>
                                    </td>
                                    <td style="width: 40px;">
                                        {{ $floor->map_height_in_pixels }}{{__('px')}}
                                    </td>
                                </tr>
                                <tr style="height: 20px;">
                                    <td style="width: 40px;">

                                    </td>
                                    <td style="text-align: center; width: 320px;">
                                        {{ $floor->map_width_in_pixels }}{{__('px')}}
                                    </td>
                                    <td style="width: 40px;"></td>
                                </tr>
                            </table>

                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <a href="{{ route('places.show', $placeId) }}" class="btn btn-default">{{__('Back')}}</a>
                    <a href="{{ route('floors.edit', [$placeId, $floor->id]) }}"
                       class="btn btn-info pull-right">{{__('Edit')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Locations')}}</h3>
                    <div class="pull-right box-tools">
                        <input type="checkbox" value="Yes" id="hide_pois_checkbox"/> <span
                                style="margin: 0 25px 0 5px">{{__('Hide POIs')}}</span>
                        <input type="checkbox" value="Yes" id="hide_findables_checkbox"/> <span
                                style="margin: 0 25px 0 5px">{{__('Hide Findables')}}</span>
                        <input type="checkbox" value="Yes" id="hide_blocks_checkbox"/> <span
                                style="margin: 0 25px 0 5px">{{__('Hide Blocks')}}</span>
                        <input type="checkbox" value="Yes" id="hide_beacons_checkbox"/> <span
                                style="margin: 0 25px 0 5px">{{__('Hide Beacons')}}</span>
                        <a href="{{ route('locations.create', [$placeId, $floor->id, 'poi']) }}"
                           class="btn btn-success btn-sm"><i class="fa fa-map-marker"></i> {{__('Add POI')}}</a>
                        <a href="{{ route('locations.create', [$placeId, $floor->id, 'findable']) }}"
                           class="btn btn-success btn-sm"><i class="fa fa-dot-circle-o"></i> {{__('Add Findable')}}</a>
                        <a href="{{ route('locations.create', [$placeId, $floor->id, 'block']) }}"
                           class="btn btn-success btn-sm"><i class="fa fa-square"></i> {{__('Add Block')}}</a>
                        <a href="{{ route('locations.create', [$placeId, $floor->id, 'beacon']) }}"
                           class="btn btn-success btn-sm"><i class="fa fa-bullseye"></i> {{__('Add Beacon')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div id="poi-list" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('POI')}}</h3>
                    <div class="pull-right box-tools">
                        <a href="{{ route('locations.create', [$placeId, $floor->id, 'poi']) }}"
                           class="btn btn-success btn-sm"><i class="fa fa-map-marker"></i> {{__('Add POI')}}</a>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <table class="table list-table">
                        <tbody>
                        <tr>
                            <th>{{__('Name')}}</th>
                            <th>{{__('POI')}}</th>
                            <th>{{__('Area')}}</th>
                            <th class="text-right"></th>
                        </tr>
                        @foreach($floor->locations as $index => $location)
                            @if($location->type == 'poi')
                                <tr class="poi-in-list">
                                    <td>
                                        <a class="modal-{{$location->id}} name-edit" data-type="text"
                                           data-pk="{{$location->id}}"
                                           data-url="{{URL::to('/')}}/ajax/location/{{$location->id}}"
                                           data-title="Enter new name"
                                           href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}">{{ $location->name or 'Unnamed' }}</a>
                                        <a style="padding-left: 5px;" data-id="{{$location->id}}" class="pencil-edit"
                                           href="#"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    <td>{{ !empty($location->poi) ? $location->poi->name : 'n/a' }}</td>
                                    <td contenteditable='true'>{{ !empty($location->area) ? $location->area : 'n/a' }}</td>
                                    <td class="text-right">
                                        {!! Form::open(['route' => ['locations.destroy', $placeId, $floor->id, $location->id], 'method' => 'DELETE']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        <a href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}"
                                           class="btn btn-primary btn-sm">{{__('Edit')}}</a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div id="beacon-list" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Beacons')}}</h3>
                    <div class="pull-right box-tools">
                        <a href="{{ route('locations.create', [$placeId, $floor->id, 'beacon']) }}"
                           class="btn btn-success btn-sm"><i class="fa fa-bullseye"></i> {{__('Add Beacon')}}</a>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <table class="table list-table">
                        <tbody>
                        <tr>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Beacon')}}</th>
                            <th>{{__('Major')}}</th>
                            <th>{{__('Minor')}}</th>
                            <th class="text-right"></th>
                        </tr>
                        @foreach($floor->locations as $index => $location)
                            @if($location->type == 'beacon')
                                <tr class="beacon-in-list">
                                    <td>
                                        <a class="modal-{{$location->id}} name-edit" data-type="text"
                                           data-pk="{{$location->id}}"
                                           data-url="{{URL::to('/')}}/ajax/location/{{$location->id}}"
                                           data-title="Enter new name"
                                           href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}">{{ $location->name or 'Unnamed' }}</a>
                                        <a style="padding-left: 5px" data-id="{{$location->id}}" class="pencil-edit"
                                           href="#"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    <td>{{ !empty($location->beacon) ? $location->beacon->name : 'n/a' }}</td>
                                    <td>{{ !empty($location->beacon) ? $location->beacon->major : 'n/a' }}</td>
                                    <td>{{ !empty($location->beacon) ? $location->beacon->minor : 'n/a' }}</td>
                                    <td class="text-right">
                                        {!! Form::open(['route' => ['locations.destroy', $placeId, $floor->id, $location->id], 'method' => 'DELETE']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        <a href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}"
                                           class="btn btn-primary btn-sm">{{__('Edit')}}</a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div id="block-list" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Blocks')}}</h3>
                    <div class="pull-right box-tools">
                        <a href="{{ route('locations.create', [$placeId, $floor->id, 'block']) }}"
                           class="btn btn-success btn-sm"><i class="fa fa-square"></i> {{__('Add Block')}}</a>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <table class="table list-table">
                        <tbody>
                        <tr>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Block')}}</th>
                            <th>{{__('Findable')}}</th>
                            <th>{{__('identifier')}}</th>
                            <th class="text-right"></th>
                        </tr>
                        @foreach($floor->locations as $index => $location)
                            @if($location->type == 'block')
                                <tr class="block-in-list">
                                    <td>
                                        <a class="modal-{{$location->id}} name-edit" data-type="text"
                                           data-pk="{{$location->id}}"
                                           data-url="{{URL::to('/')}}/ajax/location/{{$location->id}}"
                                           data-title="Enter new name"
                                           href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}">{{ $location->name or 'Unnamed' }}</a>
                                        <a style="padding-left: 5px" data-id="{{$location->id}}" class="pencil-edit"
                                           href="#"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    <td>{{ !empty($location->block) ? $location->block->name : 'n/a' }}</td>
                                    <td>{{ !empty($location->findable) ? $location->findable->name : 'n/a' }}</td>
                                    <td>{{ !empty($location->parameter_one) ? $location->parameter_one : 'n/a' }}</td>
                                    <td class="text-right">
                                        {!! Form::open(['route' => ['locations.destroy', $placeId, $floor->id, $location->id], 'method' => 'DELETE']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        <a href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}"
                                           class="btn btn-primary btn-sm">{{__('Edit')}}</a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div id="findable-list" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Findables')}}</h3>
                    <div class="pull-right box-tools">
                        <a href="{{ route('locations.create', [$placeId, $floor->id, 'findable']) }}"
                           class="btn btn-success btn-sm"><i class="fa fa-dot-circle-o"></i> {{__('Add Findable')}}</a>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <table class="table list-table">
                        <tbody>
                        <tr>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Findable')}}</th>
                            <th>{{__('Identifier')}}</th>
                            <th>{{__('Area')}}</th>
                            <th class="text-right"></th>
                        </tr>
                        @foreach($floor->locations as $index => $location)
                            @if($location->type == 'findable')
                                <tr class="findable-in-list">
                                    <td>
                                        <a class="modal-{{$location->id}} name-edit" data-type="text"
                                           data-pk="{{$location->id}}"
                                           data-url="{{URL::to('/')}}/ajax/location/{{$location->id}}"
                                           data-title="Enter new name"
                                           href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}">{{ $location->name or 'Unnamed' }}</a>
                                        <a style="padding-left: 5px" data-id="{{$location->id}}" class="pencil-edit"
                                           href="#"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    <td>{{ !empty($location->findable) ? $location->findable->name : 'n/a' }}</td>
                                    <td>{{ !empty($location->parameter_one) ? $location->parameter_one : 'n/a' }}</td>
                                    <td>{{ !empty($location->area) ? $location->area : 'n/a' }}</td>
                                    <td class="text-right">
                                        {!! Form::open(['route' => ['locations.destroy', $placeId, $floor->id, $location->id], 'method' => 'DELETE']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        <a href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}"
                                           class="btn btn-primary btn-sm">{{__('Edit')}}</a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Map Preview')}}</h3>
                </div>
                <div class="box-body">
                    @if($floor->image)
                        <div id="floor-map-preview" class="map"
                             style="background-image: url({{ $floor->getVirtualIconPath() }}?random={{ str_random(60) }}); background-size: cover; position: relative; width: 100%;">
                            <canvas id="floor-map-preview-canvas" style="left: 0; position: absolute; top: 0;"></canvas>
                            @foreach($floor->locations as $index => $location)

                                @if($location->poi && $location->poi->type == 'icon' )
                                    <a class="poi-on-map-preview floor-map-preview-location poi titletip"
                                       data-height="-1" data-width="-1" data-position-x="{{ $location->posX }}"
                                       data-position-y="{{ $location->posY }}"
                                       src="{{ $location->poi->getVirtualIconPath() }}"
                                       href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}"
                                       style="position: absolute;" title="POI: {{ $location->name }}">
                                        <img src="{{ $location->poi->getVirtualIconPath() }}"
                                             style="height: 32px; width: auto;"/>
                                    </a>
                                @elseif($location->poi && $location->poi->type == 'area' )
                                    <span class="floor-map-preview-location titletip"
                                          data-hex="{{ !empty($location->poi) ? $location->poi->color : '' }}"
                                          data-position-area="{{ $location->area }}"></span>
                                @elseif($location->type == 'beacon')
                                    <a class="beacon-on-map-preview floor-map-preview-location titletip"
                                       data-height="32" data-width="32" data-position-x="{{ $location->posX }}"
                                       data-position-y="{{ $location->posY }}"
                                       href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}"
                                       style="background-image: url({{URL::asset('/img/font-awesome-bullseye.png')}}); display: block; height: 32px; position: absolute; width: 32px;"
                                       title="Beacon: {{ !empty($location->beacon) ? $location->beacon->name : '' }}"></a>
                                @elseif($location->type == 'findable' && ($location->draw_type == 'point' || empty($location->draw_type)))
                                    <a class="findable-on-map-preview floor-map-preview-location titletip"
                                       data-height="32" data-width="32" data-position-x="{{ $location->posX }}"
                                       data-position-y="{{ $location->posY }}"
                                       href="{{ route('locations.edit', [$placeId, $floor->id, $location->id]) }}"
                                       style="background-image: url({{URL::asset('/img/font-awesome-dot-circle-o.png')}}); display: block; height: 32px; position: absolute; width: 32px;"
                                       title="Findable: {{ $location->name }}"></a>
                                @elseif($location->type == 'findable' && $location->draw_type == 'area' )
                                    <span class="floor-map-preview-location titletip" data-hex="#c1f188"
                                          data-position-area="{{ $location->area }}"></span>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>

        var MAP_WIDTH = {{ $floor->mapWidth }};
        var MAP_HEIGHT = {{ $floor->mapHeight }};

        function calculate_icon_position_x(posX, iconWidth) {
            return Math.round(posX - ( iconWidth / 2 ));
        }

        function calculate_icon_position_y(posY, iconHeight) {
            return Math.round(posY - ( iconHeight / 2 ));
        }

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

        function map_preview() {
            var floor_map_preview_width = $('#floor-map-preview').width();

            var ratio = floor_map_preview_width / MAP_WIDTH;
            var floor_map_preview_height = Math.round(MAP_HEIGHT * ratio);

            $('#floor-map-preview').css('height', floor_map_preview_height + 'px');

            var canvas = $('#floor-map-preview-canvas');
            canvas.attr('height', floor_map_preview_height).attr('width', floor_map_preview_width);

            var context = canvas[0].getContext('2d');
            context.globalCompositeOperation = 'destination-over';
            context.strokeStyle = 'rgb(0, 0, 0)';
            context.lineWidth = 1;

            $('.floor-map-preview-location').each(function (index, location) {

                var area = $(location).data('position-area');
                if (area) {
                    points = area.split(',').map(function (point) {
                        return parseInt(point * ratio, 10);
                    });

                    context.fillStyle = 'rgb(255, 255, 255)';
                    context.beginPath();
                    context.moveTo(points[0], points[1]);

                    for (var i = 0; i < points.length; i += 2) {
                        context.fillRect(points[i] - 2, points[i + 1] - 2, 4, 4);
                        context.strokeRect(points[i] - 2, points[i + 1] - 2, 4, 4);

                        if (points.length > 2 && i > 1) {
                            context.lineTo(points[i], points[i + 1]);
                        }
                    }

                    context.closePath();

                    var rgb = hexToRgb($(location).data('hex'));
                    context.fillStyle = 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', 0.3)';
                    context.fill();
                    context.stroke();

                    return;
                }

                var posX = $(location).data('position-x');
                var posY = $(location).data('position-y');
                var iconWidth = $(location).data('width');
                var iconHeight = $(location).data('height');

                /* POI Icon - Get Width and Height from Icon (Image) */
                if (iconWidth == -1 || iconHeight == -1) {
                    iconWidth = $(location).first().width();
                    iconHeight = $(location).first().height();
                }

                $(location).css({
                    left: calculate_icon_position_x(posX * ratio, iconWidth),
                    top: calculate_icon_position_y(posY * ratio, iconHeight)
                });

            });
        }

        $(window).resize(function () {
            map_preview();
        });

        $(document).ready(function () {
            map_preview();
            $('.titletip').tooltip();

            $('.name-edit').editable({
                toggle: 'manual',
                params: function (params) {
                    params._token = $('meta[name="csrf-token"]').attr('content');
                    params._method = 'PUT';
                    return params;
                },
                validate: function (value) {
                    if ($.trim(value) == '') {
                        return 'The name is required';
                    }
                }
            });
        });

        $('.pencil-edit').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            var selector = '.modal-' + $(this).data('id');
            $(selector).editable('toggle');
        });
    </script>
@endsection
