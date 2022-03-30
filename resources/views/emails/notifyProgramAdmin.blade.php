@component('mail::message')

# You have been invited to collaborate on a program
@if ($program_dept)
    {{$user_name}} has invited you to collaborate on the program: {{$program_title}} from the Department of {{$program_dept}}
@else 
    {{$user_name}} has invited you to collaborate on the program: {{$program_title}}
@endif

{{$user_name}} has invited you to collaborate on the program: {{$program_title}}.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/login'])
Log In and See Program
@endcomponent

<br>
{{ config('app.name') }}
@endcomponent
