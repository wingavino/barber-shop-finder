@component('mail::message')
# Update
Dear Customer, 

Your appointment at {{$shop_name}} is today, {{ \Carbon\Carbon::now()->format('F j, Y') }}. Please arrive on time.

@component('mail::button', ['url' => 'saber.hair'])
Click here to view the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
