@extends('layouts.app')

@section('contentheader_title', 'Teams')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    {{__('Teams')}}
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Status')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td>{{$team->name}}</td>
                                    <td>
                                        @if(auth()->user()->isOwnerOfTeam($team))
                                            <span class="label label-success">{{__('Owner')}}</span>
                                        @else
                                            <span class="label label-primary">{{__('Member')}}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if(is_null(auth()->user()->currentTeam) || auth()->user()->currentTeam->getKey() !== $team->getKey())
                                            <a href="{{route('teams.switch', $team)}}" class="btn btn-sm btn-default">
                                                <i class="fa fa-sign-in"></i> {{__('Switch')}}
                                            </a>
                                        @else
                                            <span class="label label-default">{{__('Current team')}}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
