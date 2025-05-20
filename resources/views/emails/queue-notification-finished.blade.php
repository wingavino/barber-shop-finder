@component('mail::message')
# Update
Hi,
Thanks for visiting {{$shop_name}}. We hope to serve you again soon.

@component('mail::button', ['url' => 'saber.hair'])
Click here to view the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
