@extends('layouts.app')

@section('contentheader_title', 'Users')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    {{__('Account users')}}
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Status')}}</th>
                            <th class="text-right">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        @foreach($team->users AS $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>
                                    @if($user->isOwnerOfTeam($team))
                                        <span class="label label-success">{{__('Owner')}}</span>
                                    @else
                                        <span class="label label-primary">{{__('Member')}}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if(auth()->user()->isOwnerOfTeam($team)
                                        && auth()->user()->getKey() !== $user->getKey())
                                        <form style="display: inline-block;" action="{{route('teams.members.uninvite', [$user])}}" method="post">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i> {{__('Remove from team')}}</button>
                                        </form>
                                    @endif

                                    @if(auth()->user()->isOwnerOfTeam($team)
                                        && auth()->user()->getKey() !== $user->getKey()
                                        && $user->teams()->count() >= 1)
                                        <form style="display: inline-block;" action="{{route('teams.members.destroy', [$user])}}" method="post">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> {{__('Delete user')}}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            @if($team->invites->count())
            <div class="panel panel-default">
                <div class="panel-heading clearfix">{{__('Pending invitations')}}</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{__('E-Mail')}}</th>
                            <th class="text-right">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        @foreach($team->invites AS $invite)
                            <tr>
                                <td>{{$invite->email}}</td>
                                <td class="text-right">
                                    <a href="{{route('teams.members.resend_invite', $invite)}}" class="btn btn-sm btn-default">
                                        <i class="fa fa-envelope-o"></i> {{__('Resend invite')}}
                                    </a>
                                    <form style="display: inline-block;" action="{{route('teams.members.delete_invite', [$invite])}}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> {{__('Delete')}}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading clearfix">{{__('Invite user')}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{{route('teams.members.invite', $team)}}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{__('E-Mail Address')}}</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope-o"></i> {{__('Invite to Team')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading clearfix">{{__('Create user')}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{{route('teams.members.store')}}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{__('Name')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{__('E-Mail Address')}}</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{__('Password')}}</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{__('Re-type password')}}</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope-o"></i> {{__('Create user')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
