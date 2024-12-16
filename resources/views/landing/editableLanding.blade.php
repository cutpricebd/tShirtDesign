@extends('landing.layouts.master')

@section('head')
@include('meta::manager', [
    'title' => $product->name
])

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.5/assets/owl.carousel.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('master')
<div class="container mt-4">
    <div class="text-xl md:text-4xl bg-yellow-300 text-center py-4 px-1 rounded mb-4 font-bold">
        <h2 class="mb-4">মূল্য {{$product->old_price}} টাকা</h2>
        <h2 class="mb-8">ডিস্কাউন্ট দিয়ে মূল্য – {{$product->first_price}} টাকা</h2>
        <h3 class="text-red-700 animate-bounce mt-5">স্টক সীমিত</h3>

        @if(isset($product->others_arr['videos']) && count($product->others_arr['videos']))
        <a href="#" class="mb-4 text-lg" data-scroll-nav="0">আমাদের প্রোডাক্ট খারাপ কিনা কাস্টমারের <button class="bg-green-800 px-2 py-1 rounded text-white text-base">রিভিউ দেখুন</button></a>
        @endif
    </div>

    <div class="text-center mb-3">
        <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-3 text-xl font-bold">
            অর্ডার করতে চাই

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
            </svg>
        </a>
    </div>

    @include('landing.layouts.products')

    <div data-scroll-index="0">
        @if(isset($product->others_arr['videos']) && count($product->others_arr['videos']))
            @include('landing.layouts.video')
        @endif

        <div class="dynamic_style">
            {!! $landing->body_text !!}
        </div>

        <div class="text-center mb-3">
            <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-3 text-xl font-bold">
                মূল্য ও অর্ডার প্রসেস

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
                </svg>
            </a>
        </div>

        <div class="border-yellow-300 border-2 rounded mb-4">
            <h2 class="text-2xl md:text-4xl bg-yellow-300 text-center py-2 font-bold px-1">যে কোনো সমস্যা হলে</h2>
            <div class="p-3">
                <ul class="md:px-5 mb-2">
                    <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনার ক্রয়-কৃত প্রডাক্টে কোনো প্রকার সমস্যা পেলে সাথে সাথে <a href="https://cutpricebd.com/bn/category/44/leather-jacket-winter-collections" class="text-green-800 underline">Cutpricebd.com</a> এর অফিসিয়াল নাম্বারে যোগাযোগ করুন।</span></li>
                    <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">যেকোনো প্রকার সমস্যা হলে আপনার নির্ধারিত প্রোডাক্টটিকে পরিবর্তন করে দেওয়ার সুযোগ রয়েছে শুধুমাত্র <a href="https://cutpricebd.com/bn/category/44/leather-jacket-winter-collections" class="text-green-800 underline">Cutpricebd.com</a> তেই।</span></li>
                    <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনারা যখন প্রোডাক্টগুলো নিজ হাতে যাচাই করে দেখবেন তখনই আমার কথাগুলো আপনাদের সত্য বলে মনে হবে সুতরাং আর দেরি না করে এখন জেনে নেই</span></li>
                </ul>
            </div>
        </div>

        @include('landing.layouts.image-review')

        <div class="text-center">
            <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-3 text-xl font-bold">
                অর্ডার করতে চাই

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
                </svg>
            </a>
        </div>
    </div>

    @include('landing.layouts.footer')
</div>
@endsection

@section('footer')
@include('landing.layouts.footer-script')

<!-- Push Notification -->
<script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-analytics.js"></script>
<script>
    // Initialize Firebase
    // TODO: Replace with your project's customized code snippet
    var config = {
        apiKey: "AIzaSyD_tY16t5pmmC3fd0GW9sgtNpmCBwoIPrg",
        authDomain: "oms-7a947.firebaseapp.com",
        databaseURL: "https://oms-7a947.firebaseio.com",
        projectId: "oms-7a947",
        storageBucket: "oms-7a947.appspot.com",
        messagingSenderId: "596691578904",
        appId: "1:596691578904:web:f0d48f2cefa7b33c4e536d",
        measurementId: "G-EEQ01BS1DF"
    };
    firebase.initializeApp(config);

    const messaging = firebase.messaging();
    messaging
        .requestPermission()
        .then(function () {
            console.log("Notification permission granted.");

            // get the token in the form of promise
            return messaging.getToken()
        })
        .then(function(token) {
            $.ajax({
                url: '{{route("landing.pushSubscribe")}}',
                method: 'post',
                data: {token: token, website: 'stylishjacket', _token: "{{csrf_token()}}"},
                success: function (result) {
                    console.log('success!');
                },
                error: function(){
                    console.log('error!');
                }
            });
            console.log("token is : hidden");
        })
        .catch(function (err) {
            // ErrElem.innerHTML =  ErrElem.innerHTML + "; " + err
            console.log("Unable to get permission to notify.", err);
        });

    messaging.onMessage(function(payload) {
        console.log(payload.notification.title);
    });
</script>
@endsection
