@extends('layouts.app')

@section('contentheader_title', 'API keys')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    API keys
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{__('Name')}}</th>
                            <th>{{__('User')}}</th>
                            <th>{{__('Token')}}</th>
                            <th class="text-right">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        @foreach($keys as $key)
                            <tr>
                                <td>{{ $key->name }}</td>
                                <td>{{ $key->user->name }}</td>
                                <td><code>{{ $key->api_token }}</code></td>
                                <td class="text-right">
                                    @if(auth()->user()->isOwnerOfCurrentTeam())
                                        <form style="display: inline-block;" action="{{route('apikeys.destroy', [$key])}}" method="post">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> {{__('Revoke')}}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading clearfix">Create API key</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{{route('apikeys.store')}}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{__('User')}}</label>

                            <div class="col-md-6">
                                {!! Form::select('user_id', $users, null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope-o"></i>{{__('Create API key')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
