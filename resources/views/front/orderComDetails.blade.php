@extends('front.layouts.master')

@section('head')
@include('meta::manager', [
    'title' => 'Order Payment - ' . ($settings_g['title'] ?? ''),
])
@endsection

@section('master')
{{-- @php
    $products = array();
@endphp --}}
@include('front.layouts.breadcrumb', [
    'title' => 'Order Payment',
    'url' => '#'
])

<div class="container mt-6 pb-16">
    {{--<div class="bg-green-600 rounded text-center mb-2 text-white py-3 text-lg md:text-2xl px-2">
        Thank You. Your order has been received.
    </div>--}}

    <div class="overflow-auto">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="bg-white border rounded">
                <h2 class="text-xl font-medium mb-2 bg-gray-200 p-2">Order Summary</h2>
                <div class="border-t border-gray-200 py-2 md-py-6 xl:pt-2 px-4 sm:px-6">
                    <div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                        <p>Subtotal</p>
                        <p>{{ $settings_g['currency_symbol'] ?? '৳' }}<span class="product_total">{{$order->custom_product_total}}</span></p>
                    </div>
                    <div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                        <p>Shipping Charge: </p>
                        <p class="shipping_charge_text">{{ $settings_g['currency_symbol'] ?? '৳' }}
                            {{ $order->shipping_charge }}</p>
                    </div>
                    <div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                        <p>HST: </p>
                        <p class="shipping_charge_text">{{ $settings_g['currency_symbol'] ?? '৳' }}
                            {{ $order->tax_amount }}</p>
                    </div>
                    <div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                        <p>Discount: </p>
                        <p class="shipping_charge_text">{{ $settings_g['currency_symbol'] ?? '৳' }}
                            {{ $order->discount_amount }}</p>
                    </div>
                    <div class="flex justify-between border-b text-base font-medium text-font-color-dark">
                        <p>Grand Total: </p>
                        <p>{{ $settings_g['currency_symbol'] ?? '৳' }}<span class="grand_total">{{$order->grand_total}}</span></p>
                    </div>
                </div>
            </div>
            <div class="border px-2">
                <div class="card mt-5 shadow mb-4">
                    <div class="card-header">
                        <h5>Order ID: <b>#{{$order->id}}</b></h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" id="warning_section" role="alert" hidden>
                            <p id="warning_section_message"></p>
                        </div>
                        <p>Payment Amount: <b>{{($settings_g['currency_symbol'] ?? '$') . number_format($order->grand_total, 2)}}</b></p>

                        <form role="form" action="{{ route('order.payment.strip',$order->id) }}" method="post" class="stripe-payment"
                              data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                              id="stripe-payment">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-font-color-dark text-sm font-bold mb-2">Name on Card*</label>
                                <input placeholder="Your name on card" class="shadow appearance-none border rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:shadow-outline mobile_number @error('name_on_card') border-red-500 @enderror" name="name_on_card" size='4' type='text'>

                                @error('name_on_card')
                                <span class="invalid-feedback block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-font-color-dark text-sm font-bold mb-2">Card Number*</label>
                                <input placeholder="Your card number" class="shadow appearance-none border rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:shadow-outline card-num limitthis @error('card_number') border-red-500 @enderror" name="card_number" size='20' maxlength="16" type='number'>

                                @error('card_number')
                                <span class="invalid-feedback block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class='grid'>
                                <div class='required'>
                                    <label class="block text-font-color-dark text-sm font-bold mb-2">CVC*</label>
                                    <input placeholder="your card cvc" class="shadow appearance-none border rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:shadow-outline card-cvc limitthis @error('cvc') border-red-500 @enderror" name="cvc" size='4' maxlength="4" type='number'>

                                    @error('cvc')
                                    <span class="invalid-feedback block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class= required'>
                                    <label class="block text-font-color-dark text-sm font-bold mb-2">Expiration Month*</label>
                                    <input placeholder='MM' class="shadow appearance-none border card-expiry-month rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:shadow-outline limitthis @error('card-expiry-month') border-red-500 @enderror" name="card-expiry-month" size='2' maxlength="2" type='number'>

                                    @error('card-expiry-month')
                                    <span class="invalid-feedback block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class=' required'>
                                    <label class="block text-font-color-dark text-sm font-bold mb-2">Expiration Year*</label>
                                    <input placeholder='YYYY' class="shadow appearance-none border card-expiry-year rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:shadow-outline limitthis @error('expire_year') border-red-500 @enderror" name="expire_year" size='4' maxlength="4" type='number'>

                                    @error('card-expiry-year')
                                    <span class="invalid-feedback block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="py-3">
                                <button class="text-center rounded-md border-2 border-primary-light bg-primary-light px-3 py-2 text-sm font-medium text-black inline-block" type="submit">Pay Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    $(function () {
        var $form = $(".stripe-payment");
        $('form.stripe-payment').bind('submit', function (e) {
            var $form = $(".stripe-payment"),
                inputVal = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputVal),
                $errorStatus = $form.find('div.error'),
                valid = true;
            $errorStatus.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function (i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorStatus.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-num').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeRes);
            }

        });

        function stripeRes(status, response) {
            $('#warning_section').addClass("hidden")
            if (response.error) {
                $('#warning_section').removeClass("hidden")
                $('#warning_section').removeAttr("hidden")
                $('#warning_section').html(response.error.message)
                console.log(response.error.message)
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });

    // Number length limit
    $(".limitthis").on('keypress',function(e) {
        var $that = $(this);
        var maxlength = $that.attr('maxlength');
        if($.isNumeric(maxlength)){
            if($that.val().length == maxlength) { e.preventDefault(); return; }
            $that.val($that.val().substr(0, maxlength));
        };
    });
</script>
@if($track)
    @if(env('APP_FB_TRACK'))
    <script>ra
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
