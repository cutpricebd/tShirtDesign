@extends('front.layouts.master')

@section('head')
    @include('meta::manager', [
        'title' => 'All Hot Deals - ' . ($settings_g['title'] ?? env('APP_NAME')),
    ])
@endsection

@section('master')
<div class="container">
    @include('front.layouts.breadcrumb', [
        'title' => 'All Hot Deals',
        'url' => '#'
    ])

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 mb-6">
        @foreach ($products as $product)
            @include('front.layouts.product-loop')
        @endforeach
    </div>

    <div class="my-6 mb-8">
        {{$products->links('pagination::tailwind')}}
    </div>
</div>
@endsection
