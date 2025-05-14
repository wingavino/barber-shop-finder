@component('mail::message')
# Update
Dear Customer, 

This is a courteous reminder that your service appointment at {{$shop_name}} is scheduled for today, {{ \Carbon\Carbon::now()->format('F j, Y') }}. We kindly request that you arrive on time to ensure the efficient and timely delivery of our services. We appreciate your cooperation and look forward to serving you.

@component('mail::button', ['url' => 'saber.hair'])
Click here to view the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
