{{__('You have been invited to join team')}} {{$team->name}}.<br>
{{__('Click here to join:')}} <a href="{{route('teams.accept_invite', $invite->accept_token)}}">{{route('teams.accept_invite', $invite->accept_token)}}</a>
