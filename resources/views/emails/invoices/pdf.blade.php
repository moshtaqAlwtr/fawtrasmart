@component('mail::message')
# مرحبًا {{ $invoice->client->trade_name ?? $invoice->client->first_name }}

تم إصدار فاتورة جديدة برقم: **#{{ $invoice->code }}**

يرجى مراجعة الفاتورة المرفقة في البريد.

@component('mail::button', ['url' => route('invoices.print', $invoice->id)])
عرض الفاتورة
@endcomponent

شكرًا لك،  
فريق فواترا
@endcomponent
