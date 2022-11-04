@component('mail::message')
مرحبا

اضافة فاتوره جديده

@component('mail::button', ['url' => 'http://127.0.0.1:8000/InvoicesDetails/'. $invoice_id])
 عرض الفاتوره
@endcomponent

شكرا<br>
{{$user}}
@endcomponent
