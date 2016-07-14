{{-- resources/views/emails/password.blade.php --}}
@if(config('mail.templates.reset.body'))
{!! str_replace('@{{ link }}', '<a href="' . url('password/reset/'.$token) . '">' . url('password/reset/'.$token) . '</a>', config('mail.templates.reset.body')) !!}
@else
Click here to reset your password: <a href="{{ url('password/reset/'.$token) }}">{{ url('password/reset/'.$token) }}</a>
@endif