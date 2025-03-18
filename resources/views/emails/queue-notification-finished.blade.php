@component('mail::message')
# Update
Hi,
We just wanted to thank you for using Saber during your recent visit at {{$shop_name}}.

@component('mail::button', ['url' => 'saber.hair'])
Click here to view the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
