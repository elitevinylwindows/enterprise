@component('mail::message')
# ELITE VINYL WINDOWS - Purchase Request #{{ $quote->purchaseRequest->request_number }}

Hello {{ $supplierName }},

You have a new purchase request from Elite Vinyl Windows. Please review the details below and respond appropriately.

---

**Request Summary**  
- **Request Number:** {{ $quote->purchaseRequest->request_number }}  
- **Date:** {{ \Carbon\Carbon::parse($quote->purchaseRequest->request_date)->format('F d, Y') }}  
- **Total Items:** {{ $quote->purchaseRequest->items->count() }}  

@component('mail::button', ['url' => $url])
Open Request
@endcomponent

You may approve, modify pricing and approve, or cancel the request.  
If approved or modified, you’ll also have the option to upload your quote document.

Thanks,  
Elite Vinyl Windows
Inventory Department
@endcomponent
