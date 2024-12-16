@extends('landing.layouts.builder')

@section('head')
@include('meta::manager', [
    'title' => 'Order success'
])

@vite('resources/landing/css/app.css', 'build-landing')
@endsection

@section('master')
@php
    // $products = array();
    $items = array();
@endphp
<div class="container">
    <div class="text-center">
        <h3 class="text-primary text-4xl mt-8">Your order has been received.</h3>
    </div>

    <div class="shadow-lg bg-gray-100 p-4 rounded text-black mt-6">
        <div class="card-body">
            <h6 class="mb-0">Order Number: {{ $order->id }}</h6>
            <h6 class="mb-0">Name: {{ $order->order_name }}</h6>
            <h6 class="mb-0">Date: {{ date('d-m-Y', strtotime($order->created_at)) }}</h6>

            <table class="w-full text-sm text-left text-gray-500 mt-10">
                <thead class="">
                    <tr id="table_head">
                        <th class="row-1 row-1 tbl-line-height">Sl</th>
                        <th class="row-5 row-4 tbl-line-height">Description</th>
                        <th class="row-2 row-3 tbl-line-height" style="width: 220px;">Price</th>
                        <th class="row-1 row-2 tbl-line-height" style="width: 20px;">Quantity</th>
                        <th class="row-2 row-3 tbl-line-height text-right" style="width: 200px;">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->OrderProducts as $key => $order_product)
                    @php
                        // $products[] = [
                        //     'id' => $order_product->product_id,
                        //     'quantity' => 1
                        // ];

                        $items[] = [
                            "id" => $order_product->product_id,
                            "name" => $order_product->product->name ?? 'N/A',
                            "brand" => 'Cut Price BD',
                            "category" => isset($order_product->product->categories[0]) ? $order_product->product->categories[0]->name : 'Cut Price BD',
                            "list_position" => ($key + 1),
                            "price" => $order_product->selling_price
                        ];
                    @endphp
                        <tr>
                            <td class="tbl-line-height">{{$loop->index + 1}}</td>
                            <td class="tbl-line-height">
                                {{ $order_product->product->name }}
                                @if($order_product->product_meta && $order_product->product_meta->attribute_string_json)
                                <br>
                                <p class="text-red-400 text-xs">{{$order_product->product_meta->attribute_string_json}}</p>
                                @endif
                            </td>
                            <td class="tbl-line-height">৳{{ $order_product->selling_price }}</td>
                            <td class="tbl-line-height">{{$order_product->quantity}}</td>
                            <td class="tbl-line-height text-right">৳{{ $order_product->selling_price * $order_product->quantity }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="2" class="tbl-line-height"></td>
                        <td colspan="2" class="tbl-line-height">Total</td>
                        <td class="tbl-line-height text-right">৳{{ $order->product_total }}</td>
                    </tr>

                    <tr>
                        <td colspan="2" class="tbl-line-height"></td>
                        <td colspan="2" class="tbl-line-height">Shipping Charge</td>
                        <td class="tbl-line-height text-right">৳{{ $order->shipping_cost }}</td>
                    </tr>

                    <tr class="mb-5">
                        <td colspan="2" class="tbl-line-height pt-4"></td>
                        <td colspan="2" class="tbl-line-height pt-4">Grand total</td>
                        <td class="tbl-line-height text-right pt-4">৳{{ $order->order_total }}</td>
                    </tr>

                    <tr>
                        <td colspan="2" class="tbl-line-height"></td>
                        <td colspan="2" class="tbl-line-height">Shipping Method</td>
                        <td class="tbl-line-height text-right">Cash on Delivery</td>
                    </tr>

                    <tr class="mb-5">
                        <td colspan="2" class="tbl-line-height"></td>
                        <th colspan="2" class="tbl-line-height">
                            Order Status
                        </th>
                        <th class="tbl-line-height text-right">{{ $order->status_string }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @if(env('APP_ENV') == 'production')
    <script>
        fbq('track', 'Purchase', {
            value: {{ $order->order_total }},
            currency: 'BDT',
            contents: @json($products),
            content_ids: @json($content_ids)
        }, {eventID: '{{$order->id}}'});
    </script>

    <script>
        gtag('event', 'checkout_progress', {
            "currency": "BDT",
            "items": [
                {
                    "id": "{{$order->order_products[0]->product_id ?? $order->id}}",
                    "name": "{{$order->order_products[0]->product->name ?? $order->id}}",
                    "brand": "Cut Price BD",
                    "category": "Cut Price BD",
                    "list_position": 1,
                    "price": '{{$order->order_total}}'
                }
            ]
        });
        gtag('event', 'purchase', {
            "transaction_id": "{{$order->id}}",
            "value": "{{$order->order_total}}",
            "currency": "BDT",
            "tax": 0,
            "shipping": "{{$order->shipping_cost}}",
            "items": @json($items)
        });
    </script>

    <!-- Event snippet for Purchase thanku conversion page -->
    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-951741227/YvUFCJ68lPoBEKvW6cUD',
            'transaction_id': '{{$order->id}}'
        });
    </script>

    @if($landing && $landing->pixel_access_token == 'Yes')
    <script>
        // FB Conversion Track
        $(window).on('load', function() {
            $.ajax({
                type: "POST",
                url: "{{ route('fbTrackLanding', $landing->id) }}",
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
