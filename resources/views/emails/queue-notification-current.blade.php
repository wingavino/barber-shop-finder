@component('mail::message')
# Update
Hi,
We're just here to inform you that it is your turn to be serviced at {{$shop_name}}. Please try to arrive at the shop as soon as possible to avoid being put On Hold.

@component('mail::button', ['url' => 'saber.hair'])
Click here to view the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
