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
    </div>

    <div class="text-center mb-3">
        <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-3 text-xl font-bold">
            অর্ডার করতে চাই

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
            </svg>
        </a>
    </div>

    @if(isset($product->others_arr['videos']) && count($product->others_arr['videos']))
        @include('landing.layouts.video')
    @endif

    <h3 class="text-2xl md:text-4xl text-center md:text-left text-gray-600 mt-5 mb-5">
        কেন আপনি একটি লেদার জ্যাকেট কিনবেন?
        {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M8.4,143.1c14.2-8,97.6-8.8,200.6-9.2c122.3-0.4,287.5,7.2,287.5,7.2"></path><path d="M8,19.4c72.3-5.3,162-7.8,216-7.8c54,0,136.2,0,267,7.8"></path></svg> --}}
    </h3>

    <p class="mb-3">নিজেকে স্টাইলিস্ট ও রুচি সম্পন্ন করে প্রকাশ করার জন্য লেদার জ্যাকেট এর কোন বিকল্প নেই শীতকালে।  চলুন বন্ধুরা আমরা জেনে নেই কেন আমরা একটি লেদার জ্যাকেট কিনবঃ
    </p>
    <ul class="md:px-5 mb-2">
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনাকে খুবই স্টাইলিস্ট দেখাবে</span>
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনাকে শীত থেকে বাঁচাবে</span>
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">এটি খুবই টেকসই চামড়া দিয়ে তৈরি তাই এটি দীর্ঘদিন ব্যবহার করা যাবে। </span>
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনি আপনার স্টাইল অনুযায়ী বিভিন্ন পোশাকের সাথে একটি লেদার জ্যাকেট পরতে পারবেন।
        </span>
        </li>
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">একটি লেদার জ্যাকেট কখনোই ওল্ড ফ্যাশন হয়না আপনি এটি সবসময় ব্যবহার করতে পারবেন।</span>
        </li>
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">সাধারণত মানুষ লেদার জ্যাকেটকে প্রশংসা করে অন্য যেকোনো উল সোয়েটারে তুলনায়।</span>
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">লেদার জ্যাকেট এমন একটি জিনিস যদি আপনি আপনার প্রিয় মানুষকে অথবা আপনার আত্মীয়-স্বজন বন্ধু-বান্ধবদের এটি উপহার দেন তারা সবসময় আপনাকে মনে রাখবে।</span>
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনি যদি একজন বাইকার হন তাহলে একটি লেদার জ্যাকেট আপনাকে শীত থেকে বাঁচাবে সাথে রাস্তার ধুলাবালি থেকে আপনাকে বাঁচিয়ে রাখবে।</span>
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">একটি লেদার জ্যাকেট পরিধানের মাধ্যমে আপনি নিজেকে একটি সম্ভ্রান্ত ব্যক্তি হিসেবে প্রকাশ করতে পারেন</span>
        <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনি পৃথিবীর যে কোন দেশে ভ্রমণ করেন না কেন আপনি সব সময় দেখবেন লেদার জ্যাকেট সব দেশেই সবচেয়ে বেশি জনপ্রিয়।</span>
        </li>
    </ul>

    <div class="text-center mb-3">
        <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-3 text-xl font-bold">
            মূল্য ও অর্ডার প্রসেস

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
            </svg>
        </a>
    </div>

    <div class="border-yellow-300 border-2 rounded mb-4">
        <h2 class="text-2xl md:text-4xl bg-yellow-300 text-center py-2 font-bold px-1"><a href="https://cutpricebd.com/bn/category/44/leather-jacket-winter-collections" class="text-green-800 underline">Cutpricebd.com</a> থেকে লেদার জ্যাকেট কিনলেই পাচ্ছেন আকর্ষণীয় ডিসকাউন্ট অফার!!</h2>
        <div class="p-3">
            <p class="mb-2">বাংলাদেশের যেকোনো প্রান্ত থেকে <a href="https://cutpricebd.com/bn/category/44/leather-jacket-winter-collections" class="text-green-800 underline">Cutpricebd.com</a> থেকে কোন পণ্য অর্ডার করলে খুব সহজেই পেয়ে যাবেন নির্দিষ্ট সময়ের মধ্যে। </p>
            <p>আরো থাকছি ক্যাশ অন ডেলিভারি অর্থাৎ অর্ডার করা যে কোন প্রোডাক্ট আমাদের লোক আপনার বাসায় নিয়ে দিয়ে আসবে আপনার প্রোডাক্ট হাতে নিয়ে দেখে টাকা দেওয়ার সুযোগ রয়েছে। সুতরাং আমাদের কাছ থেকে প্রোডাক্ট নিলে থাকবে না কোন প্রতারণার সম্ভাবনা।</p>
        </div>
    </div>

    <div class="border-yellow-300 border-2 rounded mb-4">
        <h2 class="text-2xl md:text-4xl bg-yellow-300 text-center py-2 font-bold px-1">জ্যাকেটের সাইজ নিয়ে যেকোনো সমস্যা হলে?</h2>
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

    <div class="border-yellow-300 border-2 rounded">
        <h2 class="text-2xl md:text-4xl bg-yellow-300 text-center py-2 font-bold px-1">কেন <a href="https://cutpricebd.com/bn/category/44/leather-jacket-winter-collections" class="text-green-800 underline">Cutpricebd.com</a> থেকে লেদার জ্যাকেট কিনবেনঃ</h2>
        <div class="p-3">
            <ul class="md:px-5 mb-2">
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">বাংলাদেশের সবচেয়ে জনপ্রিয় লেদার জ্যাকেট ব্রান্ডের প্রডাক্টগুলো আমাদের কাছে আপনারা পাবেন।</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আমরা সব সময় আমাদের কাস্টমারদেরকে একটি ভালো দামে এবং সহজলভ্য দামে প্রোডাক্ট দেওয়ার চেষ্টা করি।</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আমরা বাংলাদেশ প্রায় ১০ বছর যাবত অনলাইনে সফলতার সাথে লেদার জ্যাকেট সরবরাহ করে আসছি।</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আমরা বাংলাদেশের যেকোনো জায়গায় হোম ডেলিভারি দিয়ে থাকি।</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আমাদের জ্যাকেট কেনার জন্য আপনাদের অগ্রিম টাকা দেবার দরকার নেই।</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আমাদের ডেলিভারি ম্যান আপনাদের নিকটে জ্যাকেট নিয়ে যাবার পর আপনারা  নিজ হাতে জ্যাকেট গুলো ভাল করে দেখে বুজে ও পণ্যের মান যাচাই করে টাকা পরিষদ করতে পারবেন।</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আমাদের থেকে জ্যাকেট নেবার পর যদি আপনারা কোণ ধরণের প্রোডাক্ট সঙ্ক্রন্ত সমস্যায় পরেন তাহলে আমাদের থেকে প্রোডাক্ট বা জ্যাকেট পরিবর্তন করে নিতে পারবেন।</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">সহজলভ্য মূল্যের আমাদের পোশাকের যেকোনো সমস্যা দেখতে পেলে কোন সন্দেহ ছাড়াই লেদার জ্যাকেট কেনার বাংলাদেশের সবচেয়ে সুনামধন্য অনলাইন ওয়েবসাইট <a href="https://cutpricebd.com/bn/category/44/leather-jacket-winter-collections" class="text-green-800 underline">Cutpricebd.com</a>।
                </span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">খুবই উন্নত মানের আমাদের  লেদার জ্যাকেট গুলোতে ব্যবহার করা হয়েছে উন্নত মানের জিপার যা আপনার জ্যাকেট কি দীর্ঘমেয়াদি ভালো রাখতে সাহায্য করে।</span></li>
            </ul>
            <p class="mb-1">আমাদের কথাগুলো দ্বারা স্যাটিসফাই না হলে দয়াকরে <a class="text-green-800 underline" href="https://www.youtube.com/watch?v=vUkJVQYplzw&list=PLayNXybR2WtxsZMaFqhyknVQz9O-pkbfE" target="_blank">cutpricebd</a> থেকে পণ্যের ভিডিও দেখে তারপর অর্ডার করবেন প্লিজ। আর একই সাথে ছবির মধ্যে আপনার প্রোডাক্টের সাইজ দেওয়া আছে, আপনার আশেপাশে যেকোনো টেইলারের দোকান থেকে আপনার সাইজটা দেখে প্রয়োজনে আমাদের সাথে রি-কনফার্ম হয়ে অর্ডার করবেন।</p>
            <p class="mb-1">প্রয়োজনে আমাদের ইউটিউবে <a class="text-green-800 underline" href="https://www.youtube.com/watch?v=vUkJVQYplzw&list=PLayNXybR2WtxsZMaFqhyknVQz9O-pkbfE" target="_blank">cutpricebd</a> ঢুকে আরো অন্য ভিডিও দেওয়া আছে একটা প্রোডাক্টের জন্য, দয়াকরে সবগুলো ভিডিও দেখে তারপর অর্ডার করবেন আর সাইজটা অবশ্যই কনফার্ম হয়ে নিবেন। যেসকল সাইজটা স্টকে নাই দয়া করে সেই সকল সাইজের জন্য আপনি মেসেজের মাধ্যমে অর্ডার করে রাখুন। আমরা প্রোডাক্ট এভেলেবেল হলে আপনাকে অফারের এই দাম দিয়ে ডেলিভারি করব ইনশাল্লাহ দারাজ এর মাধ্যমে</p>
            <p>সুতরাং স্টক শেষ হয়ে যাওয়ার আগে বন্ধুরা এখনই আপনাদের পছন্দের লেদার জ্যাকেট টি আজই আপনাদের হাতে পাওয়ার জন্য আমাদের দেওয়া ফোন নাম্বারে কল করুন <a href="https://api.whatsapp.com/send?phone=8801784222266&text=" target="_blank" class="text-green-800 underline">01784222266</a> অথবা আমাদের ওয়েবসাইটের মাধ্যমে অর্ডার করতে পারেন। </p>
        </div>
    </div>

    <div class="text-center">
        <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-3 text-xl font-bold">
            অর্ডার করতে চাই

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
            </svg>
        </a>
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
                data: {token: token, website: 'jacket', _token: "{{csrf_token()}}"},
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
