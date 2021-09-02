@component('mail::message')

{{$user['fname']}} order course with title/s <br>

<ul>
@foreach ($user['course'] as $item)
    <li>{{$item['courses']}}</li>
@endforeach
</ul>

{{ config('app.name') }}
@endcomponent
