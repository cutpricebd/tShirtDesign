@extends('front.layouts.master')

@section('head')
@include('meta::manager', [
    'title' => 'Cart - ' . ($settings_g['title'] ?? ''),
])
@endsection

@section('master')
<div class="bg-gray-100">
    <div class="pt-4">
        @include('front.layouts.breadcrumb', [
            'title' => 'Cart',
            'url' => '#'
        ])

        <div class="container mt-5 pb-4 md:pb-16">
            @if(count($carts['carts']))
                <form action="{{route('order')}}" method="POST" class="grid grid-cols-1 md:grid-cols-8 gap-4 checkoutForm">
                    <div class="bg-white border rounded col-span-1 md:col-span-4 lg:col-span-5">
                        <h2 class="text-xl font-medium mb-2 bg-gray-200 p-2">Shopping Cart</h2>

                        <div class="p-4">
                            <div class="py-2 md-py-6">
                                <div class="mt-2">
                                    <div class="relative overflow-x-auto">
                                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3">
                                                        Products
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Price
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Quantity
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Sub-total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($carts['carts'] as $cart)
                                                @if($cart->Product)
                                                    @php
                                                        $price = $cart->ProductData->CustomSalePrice;
                                                    @endphp
                                                    <tr class="bg-white border-b ">
                                                        <th scope="row" class="flex px-6 py-4 font-medium text-gray-900 justify-start items-center whitespace-nowrap ">
                                                            <a href="{{route('cart.remove', $cart->id)}}" class="mt-1 text-sm text-font-color-dark hover:text-red-700 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                </svg>
                                                            </a>
                                                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                                <img src="{{$cart->Product->img_paths['small']}}" alt="{{$cart->Product->title}}" class="h-full w-full object-cover object-center">
                                                            </div>
                                                            <h3 class="px-1">
                                                                <a href="{{$cart->Product->route}}">{{$cart->Product->title}}</a>

                                                                @if($cart->Product->type == 'Variable')
                                                                    <p class="mb-0"><small>{{$cart->ProductData->attribute_items_string ?? ''}}</small></p>
                                                                @endif
                                                            </h3>
                                                        </th>
                                                        <td class="px-6 py-4">
                                                            <p class="">{{ $settings_g['currency_symbol'] ?? '৳' }}<span class="">{{$price}}</span></p>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex mt-1 cart_qty_wrap">
                                                                <button type="button" class="w-6 h-6 text-center border-2 border-[#b13481] cursor-pointer font-bold border-l-0 bg-[#b13481] text-white updateCart" data-type="minus" data-id="{{$cart->id}}">-</button>
                                                                <input type="number" value="{{$cart->quantity}}" class="h-6 border-2 border-[#b13481] px-1 w-10 focus:outline-none updateCartQty" readonly>
                                                                <button type="button" class="w-6 h-6 text-center border-2 border-[#b13481] cursor-pointer font-bold border-r-0 bg-[#b13481] text-white updateCart" data-type="plus" data-id="{{$cart->id}}">+</button>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <p class="">{{ $settings_g['currency_symbol'] ?? '৳' }}<span class="single_cart_amount">{{$price * $cart->quantity}}</span></p>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-6">
                                        <a href="{{route('homepage')}}" class="text-center rounded-md border-2 border-[#b13481] bg-transparent px-3 py-0.5 text-sm font-medium text-black float-left mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                            </svg>
                                            Back To Shopping
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border rounded col-span-1 md:col-span-4 lg:col-span-3">
                        <h2 class="text-xl font-medium mb-2 bg-gray-200 p-2">Cart Total</h2>
                        <div class="p-4">
                            <div class="border-t border-gray-200 py-2 md-py-6 xl:pt-2 px-4 sm:px-6">
                                <div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                                    <p>Subtotal</p>
                                    <p>{{ $settings_g['currency_symbol'] ?? '৳' }}<span class="product_total">{{$carts['product_total']}}</span></p>
                                </div>
                                {{--<div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                                    <p>Payment Method: </p>
                                    <p>Cash On Delivery</p>
                                </div>--}}
                                <div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                                    <p>Shipping Charge: </p>
                                    <p>{{ $settings_g['currency_symbol'] ?? '৳' }} <span class="shipping_charge_text"> {{ $carts['shipping_charge'] }} </span></p>
                                </div>
                                <div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                                    <p>Tax: </p>
                                    <p>{{ $settings_g['currency_symbol'] ?? '৳' }} <span class="tax_amount_text"> {{ $carts['tax_amount'] }} </span></p>
                                </div>
                                <div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                                    <p>Grand Total: </p>
                                    <p>{{ $settings_g['currency_symbol'] ?? '৳' }}<span class="grand_total">{{$carts['subtotal']}}</span></p>
                                </div>
                                <div class="mt-6">
                                    <a href="{{route('checkout')}}" class=" flex text-center rounded-md border-2 border-[#b13481] bg-[#b13481] px-3 py-0.5 text-sm font-medium text-white float-right mb-3">
                                        <span class="px-2">Process to Checkout</span>
                                        <svg class="w-4 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="bg-white border rounded p-4">
                    <div class="text-center text-lg py-20">
                        <p>No Item in in cart. <a href="{{route('homepage')}}" class="text-primary">Continue Shopping</a></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script>
        $(document).on('click', '.updateCart', function(){
            let type = $(this).data('type');
            let calculated_quantity = 0;
            let cart_id = $(this).data('id');
            let quantity = $(this).closest('.cart_qty_wrap').find('.updateCartQty').val();

            if(type == 'plus'){
                calculated_quantity = Number(quantity) + 1;
            }else{
                calculated_quantity = Number(quantity) - 1;
            }

            if(calculated_quantity > 0){
                $(this).closest('.cart_qty_wrap').find('.updateCartQty').val(calculated_quantity);
                $.ajax({
                url: '{{route("cart.update")}}',
                method: 'POST',
                dataType: 'JSON',
                context: this,
                data: {cart_id, quantity: calculated_quantity, _token: '{{csrf_token()}}'},
                success: function(result){
                    $('.top_cart_count').html(result.summary.count);
                    $('.product_total').html(result.summary.product_total);
                    $('.shipping_charge_text').html(result.summary.shipping_charge);
                    $('.tax_amount_text').html(result.summary.tax_amount);

                    $(this).closest('tr').find('.single_cart_amount').html(result.single_amount);
                    $('.grand_total').html(Number(result.summary.subtotal));
                },
                error: function(){
                    cAlert('error', 'Update cart error!');
                }
            });
            }
        });

    </script>

    @if(env('APP_FB_TRACK'))
    <script>
        fbq('track', 'InitiateCheckout', {
            value: {{ $carts['product_total'] }},
            currency: 'BDT'
        });
    </script>
    @endif

    @if(Info::Settings('fb_api', 'track') == 'Yes')
    <script>
        // FB Conversion Track
        $(window).on('load', function() {
            $.ajax({
                type: "POST",
                url: "{{ route('fbTrack') }}",
                data: {
                    _token: '{{csrf_token()}}',
                    track_type: 'InitiateCheckout',
                    data: {
                        value: '{{ $carts["product_total"] }}',
                        currency: 'BDT'
                    }
                },
                success: function (response) {
                    if(response == 'true'){
                        console.log('FB Tracked Page Viewed!');
                    }else{
                        console.log('FB Tracked Failed');
                    }
                },
                error: function(){
                    console.log('FB Tracked Error Page View!');
                }
            });
        });
    </script>
    @endif
@endsection
