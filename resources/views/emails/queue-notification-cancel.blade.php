@component('mail::message')
# Update
Hi,
We're just here to inform you that your ticket at {{$shop_name}} has been canceled. Please try to arrive at the shop as soon as possible next time to avoid being removed from the queue.

@component('mail::button', ['url' => 'saber.hair'])
Click here to view the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
