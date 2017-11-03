@component('mail::message')

{!!$content!!}
Thanking You,<br>
{{ config('app.name') }}
@endcomponent
