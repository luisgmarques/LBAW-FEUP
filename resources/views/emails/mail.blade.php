@component('mail::message')
# Order Shipped

Your order has been shipped!

@component('mail::button', ['url' => 'google.com'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent