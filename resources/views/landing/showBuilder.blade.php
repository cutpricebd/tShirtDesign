@extends('landing.layouts.builder')

@section('head')
@include('meta::manager', [
    'title' => $landing->title
])
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link href="{{asset('l-build/'. $landing->id .'/style.css')}}" rel="stylesheet" />
@vite('resources/landing/css/app.css', 'build-landing')
{!! $landing->head_code !!}
@endsection

@section('master')
{!! $landing->body_code !!}
@include('l-build.'. $landing->id .'.index')
@endsection

@section('footer')
{!! $landing->footer_code !!}

@include('landing.layouts.footer-script')
@endsection
