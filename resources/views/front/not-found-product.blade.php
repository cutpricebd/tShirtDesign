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
    'title' => 'Product Unavailable',
        'url' => '#'
])

<div class="container">
    <div class="my-10 w-full overflow-hidden">
        <div class="border">
            <h2 class="bg-primary py-1 px-2 font-semibold text-white mb-2">Product did not found</h2>
            <div class="px-3 mb-2 responsive_video">
                This item might have been discontinued or removed from our inventory. Please use the search bar to
                find similar items or visit our homepage to explore our full range of products.

                This category might have been updated or removed. Please return to our
                homepage or check out other categories to find what you’re looking for.
                <p>This product is no longer available in our store. We apologize for any inconvenience. Browse our <a href="{{ url('/') }}">Home</a> for similar/other items.</p>

                {{-- এই আইটেমটি আমাদের ইনভেন্টরি থেকে বন্ধ বা সরানো হতে পারে। অনুগ্রহ করে সার্চ বার ব্যবহার করুন
                অনুরূপ আইটেম খুঁজুন বা আমাদের পণ্যের সম্পূর্ণ পরিসীমা অন্বেষণ করতে আমাদের <a href="/"> হোমপেজে </a> যান। --}}
            </div>
        </div>
    </div>

    <div class="mt-6">
        <h2 class="bg-primary py-1 px-2 font-semibold rounded text-white mb-4">You Wanted to look like</h2>
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
