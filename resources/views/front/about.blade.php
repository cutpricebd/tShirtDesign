@extends('front.layouts.master')

@section('head')
    @include('meta::manager', [
        'title' => 'About page - ' . ($settings_g['title'] ?? '')
    ])
@endsection

@section('master')

{{-- Top Bannder --}}
 
<div
    class="relative w-full h-64 md:h-96 lg:h-[500px] overflow-hidden mt-4 mb-4 m-2 rounded-lg"
    onmouseenter="this.classList.add('hovered')"
    onmouseleave="this.classList.remove('hovered')"
>
    @php
        $aboutItem1 = $aboutpage[0] ?? null; // Second item in the collection
    @endphp

    {{-- Cover Image --}}
    <img
        src="{{ asset($aboutItem1->image) }}" {{-- Path to your cover image --}}
        alt="Cover Image"
        style="object-fit: cover; transition: transform 0.5s; width: 100%; height: 100%;"
        class="cover-image rounded-lg z-0"
    />

    {{-- Darker overlay effect --}}
    <div class="absolute inset-0 transition-all duration-500 ease-in-out bg-black bg-opacity-60' : 'bg-black bg-opacity-10"></div>

    {{-- Overlay title (show on hover) --}}
    <div class="title-overlay absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-500 ease-in-out">
        <h1 class="text-white text-2xl xs:text-3xl sm:text-4xl md:text-4xl lg:text-5xl font-bold uppercase">
          About Page
        </h1>
    </div>
</div>



{{-- Two Card Design --}}

<div class="space-y-12 py-8 px-4 md:px-8 lg:px-12 bg-[#fbeeee]">
    {{-- Section 1: Text on the left, Image on the right --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        @php
            $aboutItem1 = $aboutpage[0] ?? null; // First item in the collection
        @endphp
        @if($aboutItem1)
            <div class="mt-4">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-semibold mb-8 uppercase tracking-widest text-left md:text-left">
                    {{ $aboutItem1->headline }}
                </h2>
                <p class="text-base sm:text-lg md:text-xl font-semibold text-gray-600 font-serif">
                    {{ $aboutItem1->paragraph }}
                </p>
            </div>
            <div class="relative w-full overflow-hidden rounded-lg">
                <img
                    src="{{ asset($aboutItem1->image) }}"
                    alt="about1stimage"
                    class="rounded-lg hover:brightness-75 hover:scale-105 transition-transform duration-300 h-64"
                    style="width: 100%; height:auto; object-fit: cover;"
                />
            </div>
        @endif
    </div>

    {{-- Section 2: Image on the left, Text on the right --}}
    <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10">
        @php
            $aboutItem2 = $aboutpage[1] ?? null; // Second item in the collection
        @endphp
        @if($aboutItem2)
            <div class="relative w-full overflow-hidden rounded-lg">
                <img
                    src="{{ asset($aboutItem2->image) }}"
                    alt="about2ndimage"
                    class="rounded-lg hover:brightness-75 hover:scale-105 transition-transform duration-300"
                    style="width: 100%; height: auto; object-fit: cover;"
                />
            </div>
            <div class="text-left space-y-4">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-semibold mb-8 uppercase tracking-widest text-left md:text-left">
                    {{ $aboutItem2->headline }}
                </h2>
                <p class="text-base sm:text-lg md:text-xl font-serif text-gray-600 mt-6 sm:mt-10 font-semibold">
                    {{ $aboutItem2->paragraph }}
                </p>
            </div>
        @endif
    </div>
</div>


 {{-- about page Cover Image --}}


<div
    class="relative w-full h-64 md:h-96 lg:h-[500px] overflow-hidden mt-4 mb-4 m-2 rounded-lg"
    onmouseenter="this.classList.add('hovered')"
    onmouseleave="this.classList.remove('hovered')"
>
    @php
        $aboutItem2 = $aboutpage[1] ?? null; // Second item in the collection
    @endphp

    {{-- Cover Image --}}
    <img
        src="{{ asset($aboutItem2->image) }}" {{-- Path to your cover image --}}
        alt="Cover Image"
        style="object-fit: cover; transition: transform 0.5s; width: 100%; height: 100%;"
        class="cover-image rounded-lg z-0"
    />

    {{-- Darker overlay effect --}}
    <div class="overlay absolute inset-0 transition-all duration-500 ease-in-out bg-black bg-opacity-10"></div>

    {{-- Overlay title (show on hover) --}}
    <div class="title-overlay absolute inset-0 flex items-center justify-start opacity-0 transition-opacity duration-500 ease-in-out">
        <h1 class="text-gray-400 text-sm xs:text-md sm:text-lg md:text-1xl lg:text-2xl font-bold capitalize ml-4">
           Fashion is defined in a number of different ways <br />
                 and its application can be sometimes unclear
        </h1>
    </div>
</div>

{{-- Add this style in your Blade file or a linked CSS file --}}
<style>
    .cover-image {
        transform: scale(1);
    }
    .hovered .cover-image {
        transform: scale(1.05);
    }
    .overlay {
        background-color: rgba(0, 0, 0, 0.1);
    }
    .hovered .overlay {
        background-color: rgba(0, 0, 0, 0.6);
    }
    .title-overlay {
        opacity: 0;
    }
    .hovered .title-overlay {
        opacity: 1;
    }
</style>


{{-- About Page subscripe portion --}}

<div class="w-full  my-4 bg-[#fbeeee] p-10"> {{-- Changed to 7/12 for more precise width --}}
    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4 md:mb-6 uppercase">Subscribe to our newsletter</h2>
    <p class="text-base md:text-lg lg:text-xl mb-6 font-semibold">
        Be the first to know about the latest trends, sales updates, and more.
    </p>
    <form class="flex flex-col md:flex-row items-center gap-4">

        {{-- action="{{ route('subscribe') }}" method="POST --}}
        @csrf {{-- CSRF token for security --}}
        <input
            type="email"
            name="email"
            placeholder="Your E-mail"
            class="w-full md:w-64 p-2 border border-gray-400 focus:outline-none shadow-md"
            required
        />
        <button
            type="submit"
            class="px-6 py-2 border border-black bg-transparent transition duration-300 rounded-lg hover:bg-pink-300 ease-in-out font-bold shadow-sm">
            Subscribe
        </button>
    </form>
</div>



@endsection
