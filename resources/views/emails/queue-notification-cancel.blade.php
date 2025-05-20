@component('mail::message')
# Update
Hi,
Your Appointment at {{$shop_name}} has been canceled due to late arrival or no show. You may rebook anytime.

@component('mail::button', ['url' => 'saber.hair'])
Click here to view the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
