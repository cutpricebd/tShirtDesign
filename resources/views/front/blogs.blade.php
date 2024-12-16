@extends('front.layouts.master')

@section('head')
    @include('meta::manager', [
        'title' => 'Blogs - ' . ($settings_g['title'] ?? '')
    ])
@endsection


@section('master')
<div class="flex justify-center uppercase p-10">
    <h1 class="bg-gray-600 text-white p-4 rounded-3xl">this is blogs page</h1>
</div>

@endsection

