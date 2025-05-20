@component('mail::message')
# Update
Dear Customer, 

Your appointment at {{$shop_name}} is today. Be on time so we can serve you promptly. Thank you

@component('mail::button', ['url' => 'saber.hair'])
Click here to view the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
