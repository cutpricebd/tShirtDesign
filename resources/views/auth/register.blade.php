@extends('front.layouts.master')

@section('head')
    @include('meta::manager', [
        'title' => 'Register - ' . ($settings_g['title'] ?? ''),
    ])
@endsection

@section('master')
<div class="container">
    <div class="flex justify-center">
        <div class="w-full max-w-md py-16">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 border border-gray-100" method="POST" action="{{route('register')}}">
                @csrf

                <div class="text-center mb-4">
                    <h4 class="text-xl">Register new Account</h4>
                </div>

                <div class="mb-4">
                    <label class="block text-font-color-dark text-sm font-bold mb-2">Full Name*</label>

                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:outline-none focus:shadow-outline" value="{{old('name')}}" name="name" required>
                </div>

                <div class="mb-4">
                    <label class="block text-font-color-dark text-sm font-bold mb-2">Email Address*</label>

                    <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:outline-none focus:shadow-outline" value="{{old('email')}}" name="email" required>
                </div>

                <div class="mb-4">
                    <label class="block text-font-color-dark text-sm font-bold mb-2">Full Address*</label>

                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:outline-none focus:shadow-outline" value="{{old('address')}}" name="address" required>
                </div>

                <div class="mb-4">
                    <label class="block text-font-color-dark text-sm font-bold mb-2">Password*</label>

                    <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:outline-none focus:shadow-outline" name="password" required>
                    <p class="text-red-500 text-xs italic">Please choose a password.</p>
                </div>

                <div class="mb-4">
                    <label class="block text-font-color-dark text-sm font-bold mb-2">Confirm Password*</label>

                    <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-font-color-dark leading-tight focus:outline-none focus:shadow-outline" name="password_confirmation" required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-primary-light hover:bg-primary text-font-color-light font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
                </div>
                <p>Already have account? <a href="{{route('login')}}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Login Now</a></p>
            </form>
        </div>
    </div>
</div>
@endsection

