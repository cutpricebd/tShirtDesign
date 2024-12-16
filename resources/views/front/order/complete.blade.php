@extends('front.layouts.master')

@section('head')
    @include('meta::manager', [
        'title' => 'Order Success - ' . ($settings_g['title'] ?? ''),
    ])
@endsection

@section('master')
    {{-- @php
        $products = array();
    @endphp --}}
    @include('front.layouts.breadcrumb', [
        'title' => 'Order Success',
        'url' => '#'
    ])

    <div class="container mt-6 pb-16">
        <div class="bg-green-600 rounded text-center mb-2 text-white py-3 text-lg md:text-2xl px-2">
            Thank You. Your order has been received.
        </div>

        <div class="overflow-auto">
            <table class="w-full border text-left mb-8">
                <thead class="border-b">
                <tr>
                    <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                        Product
                    </th>
                    <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                        Price
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->OrderProducts as $i => $product)
                    {{-- @php
                        $products[] = [
                            'id' => $product->product_id,
                            'quantity' => $product->quantity
                        ];
                    @endphp --}}

                    <tr class="border-b">
                        <td class="px-3 py-2 text-sm text-gray-900 border-r font-light">
                            <img src="{{ $product->Product->img_paths['small'] ?? asset('img/default-img.png') }}" alt="{{ $product->Product->title ?? 'n/a' }}" class="w-20 h-20 object-contain">
                            <p class="text-lg">{{ $product->Product->title ?? 'n/a' }}</p>
                            <p class="mb-0"><small>{{$product->ProductData->attribute_items_string}}</small></p>
                            <p class="text-lg">৳ {{ $product->sale_price }} x {{$product->quantity}}</p>
                        </td>
                        <td class="text-gray-900 font-light px-3 py-2 whitespace-nowrap border-r text-lg">
                            {{ $settings_g['currency_symbol'] ?? '৳' }} {{$product->sale_price * $product->quantity}}
                        </td>
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                    <tr class="border-b">
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            Delivery Cost
                        </th>
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            {{ $settings_g['currency_symbol'] ?? '৳' }} {{$order->shipping_charge}}
                        </th>
                    </tr>
                    <tr class="border-b">
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            HST
                        </th>
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            {{ $settings_g['currency_symbol'] ?? '৳' }} {{$order->tax_amount}}
                        </th>
                    </tr>
                    <tr class="border-b">
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            Discount
                        </th>
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            {{ $settings_g['currency_symbol'] ?? '৳' }} {{$order->discount_amount}}
                        </th>
                    </tr>
                    <tr class="border-b">
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            Total
                        </th>
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            {{ $settings_g['currency_symbol'] ?? '৳' }} {{$order->grand_total}}
                        </th>
                    </tr>
                    <tr class="border-b">
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            Order Number
                        </th>
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            {{$order->id}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            Payment Method
                        </th>
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            {{ $order->payment_method??'Cash on Delivery' }}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            Payment Status
                        </th>
                        <th scope="col" class="text-sm font-semibold text-gray-900 px-3 py-2 border-r">
                            {{ $order->payment_status??'Unpaid' }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center mb-8">
            <a href="{{route('homepage')}}" class="text-center rounded-md border-2 border-primary-light bg-primary-light px-3 py-2 text-sm font-medium text-white inline-block">আরো শপিং করুন</a>
        </div>
    </div>
@endsection

@section('footer')
    @if(isset($track) && $track)
        @if(env('APP_FB_TRACK'))
            <script>
                fbq('track', 'Purchase', {
                    value: '{{$order->grand_total}}',
                    currency: 'BDT',
                    contents: @json($products),
                    content_ids: @json($content_ids)
                }, {eventID: '{{$order->id}}'});
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
                            track_type: 'Purchase',
                            data: {
                                event_id: '{{$order->id}}',
                                custom_data: {
                                    value: '{{$order->grand_total}}',
                                    currency: 'BDT',
                                    content_ids: @json($content_ids),
                                    content_type: "product",
                                    contents: @json($products),
                                }
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
    @endif
@endsection