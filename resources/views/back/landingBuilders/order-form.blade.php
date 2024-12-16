@if(($environment ?? 'Live') == 'Development')
<div class="mt-6 border-primary border-2 p-3 rounded h-32 md:h-96 text-center" data-gjs-copyable="false" data-gjs-draggable="false" data-gjs-editable="false" data-gjs-removable="false"><h3 class="mt-5 text-2xl" data-gjs-copyable="false" data-gjs-draggable="false" data-gjs-editable="false" data-gjs-removable="false">Products & Order Form</h3><p data-gjs-copyable="false" data-gjs-draggable="false" data-gjs-editable="false" data-gjs-removable="false">This content are not editable!</p></div>
@else
@include('landing.layouts.products')

@include('landing.layouts.order-form', [
    'order_type' => 'builder'
])
@endif
