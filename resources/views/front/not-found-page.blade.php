@extends('front.layouts.master')
@section('head')
    @include('meta::manager', [
        "title" => ($settings_g['title'] ?? env('APP_NAME')) . ' - ' . ($settings_g['slogan'] ?? env('APP_NAME')),
        "description" => $settings_g['meta_description'] ?? '',
        "keywords" => $settings_g['keywords'] ?? ''
    ])
@endsection

@section('master')
@include('front.layouts.breadcrumb', [
    'title' => 'Unavailable',
        'url' => '#'
])

<div class="container">
    <div class="my-10 w-full overflow-hidden">
        <div class="border">
            <h2 class="bg-primary py-1 px-2 font-semibold text-white mb-2">অনুসন্ধান পাওয়া যায়নি</h2>
            <div class="px-3 mb-2 responsive_video">
                {{--This page/category might have been updated or removed. Please return to our
                homepage or check out other page/categories to find what you’re looking for.--}}
                এই বিষয়বস্তু আপডেট বা মুছে ফেলা হতে পারে. অনুগ্রহ করে সার্চ বার ব্যবহার করুন
                অনুরূপ বিষয়বস্তু খুঁজুন বা আমাদের পণ্যের সম্পূর্ণ পরিসীমা অন্বেষণ করতে আমাদের <a href="/"> হোমপেজে </a> বা অন্যান্য পৃষ্ঠা/বিভাগ দেখুন।
            </div>
        </div>
    </div>

    <div class="mt-6">
        <h2 class="bg-primary py-1 px-2 font-semibold rounded text-white mb-4">আপনি পছন্দ করতে পারেন</h2>
        @php
            $related_products = \App\Models\Product\Product::where('status', 1)
            ->where('deleted_at', null)->distinct()
            ->inRandomOrder()
            ->take(24)->get();
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 mb-3">
            @foreach ($related_products as $related_product)
                @if($related_product)
                    @include('front.layouts.product-loop', [
                        'product' => $related_product
                    ])
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('footer')

@endsection
