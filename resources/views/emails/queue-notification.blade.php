@component('mail::message')
# Update
Hi,
We're just here to inform that you are next in line to be serviced. Please try to arrive at the shop as soon as possible to avoid being put On Hold.

@component('mail::button', ['url' => 'saber.hair'])
Click here to view the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
