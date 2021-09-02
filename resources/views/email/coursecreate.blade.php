@component('mail::message')

{{$user['fname']}} created a course entitled <b> {{$user['course']}} <b> for approval.


{{ config('app.name') }}
@endcomponent
