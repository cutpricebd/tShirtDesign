@extends('front.layouts.master')
@section('head')
    @include('meta::manager', [
        'title' => $product->title . ' - ' . ($settings_g['title'] ?? env('APP_NAME')),
        'image' => $product->img_paths['large'],
        'description' => $product->meta_description,
        'keywords' => $product->meta_tags
    ])
    <style>
        .sp_variation_all li label {
            border-radius: 10% !important;
        }
    </style>
@endsection

@section('master')
@include('front.layouts.breadcrumb', [
    'title' => $product->title,
        'url' => $product->route
])

<div class="container">
    <div class="mt-6 border-2 shadow-2xl p-6 rounded-md">
        <div class="grid grid-cols-1 md:grid-cols-9 gap-8">
            <div class="col-span-1 md:col-span-4">
                <img src="{{$product->img_paths['original']}}" alt="{{$product->title}}" class="w-full h-auto object-center shadow-md rounded border-2 hover:scale-105 duration-700" width="300" height="160" id="product_preview">

                <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-2 mt-4">
                    <div class="block shadow cursor-pointer hover:shadow-lg">
                        <img src="{{$product->img_paths['small']}}" onclick="changeProductImage('{{$product->img_paths['original']}}');" width="80" height="80" alt="{{$product->title}}" class="w-full h-20 object-center object-cover">
                    </div>

                    @foreach ($product->Gallery as $gallery)
                        <div class="block shadow cursor-pointer hover:shadow-lg" onclick="changeProductImage('{{$gallery->paths['original']}}');">
                            <img src="{{$gallery->paths['small']}}" width="80" height="80" alt="{{$product->title}}" class="w-full h-20 object-center object-cover">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-span-1 md:col-span-5">
                <h1 class="text-xl md:text-2xl font-semibold tracking-tight text-gray-700 border-b-2 border-double pb-2">{{$product->title}}</h1>

                <div class="grid grid-cols-12">
                    <div class="col-span-12 md:col-span-12">
                        <div class="flex gap-5 text-3xl mt-4 border-b-2 border-double pb-2" style="color: #dc3545">
                            <div>
                                {{ $settings_g['currency_symbol'] ?? '৳' }} <span class="single_product_price price_amount">{{$product->prices['sale_price']}}</span>
                                @if($product->prices['regular_price'] > 0 && $product->prices['sale_price'] < $product->prices['regular_price'])
                                    <br><span class="text-black line-through text-xl">{{ $settings_g['currency_symbol'] ?? '৳' }} {{$product->prices['regular_price']}}</span>
                                @endif
                            </div>
                            <div>
                                <div class="flex px-2 gap-2">
                                    <div class="flex px-2 bg-orange-100 rounded-xl justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                        </svg>
                                        <span class="text-xs px-1">{{ $product->average_rating  }}</span>
                                    </div>
                                    <div class="flex bg-blue-200 rounded-xl text-blue-700 px-1 py-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                        </svg>
                                        <span class="text-xs px-1">{{ $product->total_review }} Reviews</span>
                                    </div>
                                </div>
                                <div class="px-2 text-gray-500">
                                    <span class="text-xs"><span class="text-green-600">{{ ($product->average_rating/5) *100 }}%</span> of buyer recommended this</span>
                                </div>
                            </div>

                        </div>

                       {{-- <p class="mt-4 text-sm text-white inline-block px-3 py-0.5 product_code" style="background: #74c951"><span>Product Code: {{$product->id}}</span></p>
--}}
                        <div class="sp_variation">
                            @foreach ($product->VariableAttributes as $key=>$attribute)
                                <div class="gap-5 mb-2 mt-2">
                                    <div class="col-span-4 md:col-span-2">
                                        <span class="mr-2 mt-2 d-inline-block"><b>{{$attribute->name}}:</b></span>
                                    </div>

                                    <div class="col-span-8 md:col-span-10">
                                        <ul class="sp_variation_all npnls">
                                            @foreach ($attribute->AttributeItems as $key2=>$attribute_item)
                                                @if(in_array($attribute_item->id, $product->attribute_items_arr))
                                                <li>
                                                    <input type="radio" name="attr_id_{{$attribute->id}}" id="av_id_{{$attribute_item->id}}" class="co_radio" {{ $key == $key2?'checked':'' }} value="{{$attribute->id . ':' . $attribute_item->id}}">
                                                    <label for="av_id_{{$attribute_item->id}}" class="cartOptions">{{$attribute_item->name}}</label>
                                                </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <br>
                            @endforeach
                        </div>

                        <div class="mt-10">
                            <form class="flex w-full" action="{{route('cart.directOrder')}}" method="get">
                                <div>
                                    <input type="hidden" name="product" value="{{$product->id}}">
                                    @if($product->VariableAttributes && count($product->VariableAttributes))
                                        <input type="hidden" name="product_data_id" value="{{ $product->VariableAttributes[0]['id'] }}" class="product_data_id">
                                    @endif
                                    <div class="mb-4 flex px-4">
                                        <button class="w-8 h-8 text-center  cursor-pointer font-bold border-l-0 bg-gray-200 text-black" type="button" onclick="updateProQuantity('minus')">-</button>
                                        <input name="quantity" type="number" value="1" id="single_cart_quantity" class="h-8  px-1 w-10 focus:outline-none text-center rounded-none">
                                        <button class="w-8 h-8 text-center  cursor-pointer font-bold border-l-0 bg-gray-200 text-black" type="button" onclick="updateProQuantity('plus')">+</button>
                                    </div>
                                </div>

                                <button type="submit" class=" flex py-2 px-4 bg-[#b13481] text-white rounded-3xl hover:bg-green-700 duration-300 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4" width="20" height="20">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    <span class="px-2">Add to Cart</span>
                                </button>
                            </form>

                            {{--<button type="button" class="py-2 px-4 sm:px-8 bg-[#b13481] text-white rounded-3xl hover:bg-[#8b2263] duration-300" onclick="addToCart('{{$product->id}}')">Add To Cart</button>
--}}
                        </div>
                        <div class="card bg-gray-100 px-4 py-2 rounded-xl">
                            <div class="flex py-3">
                                <div>
                                    <svg color="#b13481" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 20 20"><g fill="currentColor"><path d="M8 16.5a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0m7 0a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0"/><path d="M3 4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h1.05a2.5 2.5 0 0 1 4.9 0H10a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1zm11 3a1 1 0 0 0-1 1v6.05q.243-.05.5-.05a2.5 2.5 0 0 1 2.45 2H17a1 1 0 0 0 1-1v-5a1 1 0 0 0-.293-.707l-2-2A1 1 0 0 0 15 7z"/></g></svg>
                                </div>
                                <div class="px-2">
                                    <h4>Free delivery</h4>
                                    <p>Enter your postal code for delivery available</p>
                                </div>
                            </div>
                            <hr>
                            <div class="flex py-3">
                                <div>
                                    <svg color="#b13481" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" width="30" height="30">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                </div>
                                <div class="px-2">
                                    <h4>Return delivery</h4>
                                    <div>Free 30 days delivery return details</div>
                                </div>
                            </div>
                        </div>

                        {{--<table class="w-full mt-4 text-black text-sm">
                            <tbody>
                                <tr>
                                    <td style="padding-left: 0;border-bottom: 1px solid #ddd;">
                                        Inside Dhaka City
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd;">
                                    <b>{{ $settings_g['currency_symbol'] ?? '৳' }} {{env('INSIDE_DHAKA_DELIVERY_CHARGE')}}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 0;border-bottom: 1px solid #ddd;">
                                        Outside Dhaka City
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd;">
                                    <b>{{ $settings_g['currency_symbol'] ?? '৳' }} {{env('OUTSIDE_DHAKA_DELIVERY_CHARGE')}}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>--}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--<div class="my-10 w-full overflow-hidden">
        <div class="border">
            <h2 class="bg-[#b13481] py-1 px-2 font-semibold text-white mb-2">Product Details</h2>

            <div class="px-3 mb-2 responsive_video">
                {!! $product->description !!}
            </div>
        </div>
    </div>--}}
    <div class="card border-2 shadow-2xl my-4 rounded-md">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700 mt-10">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center justify-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="description-tab" data-tabs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="false">Description</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="additional_information-tab" data-tabs-target="#additional_information" type="button" role="tab" aria-controls="additional_information" aria-selected="false">Additional Information</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="specification-tab" data-tabs-target="#specification" type="button" role="tab" aria-controls="specification" aria-selected="false">Specification</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="reviews-tab" data-tabs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg" id="description" role="tabpanel" aria-labelledby="description-tab">
                <div class="content">{!! $product->description !!}</div>
            </div>
            <div class="hidden p-4 rounded-lg" id="additional_information" role="tabpanel" aria-labelledby="additional_information-tab">
                <div class="content">{!! $product->short_description !!}</div>
            </div>
            <div class="hidden p-4 rounded-lg" id="specification" role="tabpanel" aria-labelledby="specification-tab">
                <div class="content">{!! $product->specification !!}</div>
            </div>
            <div class="hidden p-4 rounded-lg" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div>
                    <div class="justify-center text-center px-2 py-5">
                        <h1 class="justify-center text-center">Customer Reviews</h1>
                        <div class="justify-center text-center">
                            <div class="flex items-center justify-center">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg class="w-4 h-4 text-gray-300 me-1 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">{{ $product->average_rating }}</p>
                                    <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">out of</p>
                                    <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">5</p>
                                </div>
                                <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full dark:bg-gray-400"></span>
                                <a href="#" class="text-sm font-medium text-gray-900 underline hover:no-underline">{{ $product->total_review }} reviews</a>
                            </div>
                        </div>
                    </div>
                    @foreach($product->review as $review)
                        <div>
                            <figure class="max-w-screen border px-2 py-2">
                                <div class="flex items-center mb-4 text-yellow-300">
                                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg class="w-5 h-5 me-1 {{ $review->rating > 1 ?'':'text-gray-300' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg class="w-5 h-5 me-1 {{ $review->rating > 2 ?'':'text-gray-300' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg class="w-5 h-5 me-1 {{ $review->rating > 3 ?'':'text-gray-300' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg class="w-4 h-4 ms-1 {{ $review->rating > 4 ?'':'text-gray-300' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                </div>
                                <blockquote>
                                    <p class="text-2xl font-semibold text-gray-900">
                                        {{ $review->review }}
                                    </p>
                                </blockquote>
                                <figcaption class="flex items-center mt-6 space-x-3 rtl:space-x-reverse">
                                    <img class="w-6 h-6 rounded-full" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png" alt="profile picture">
                                    <div class="flex items-center divide-x-2 rtl:divide-x-reverse divide-gray-300 dark:divide-gray-700">
                                        <cite class="pe-3 font-medium text-gray-900">{{ $review->name }}</cite>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <h2 class=" py-1 px-2 font-semibold text-2xl rounded text-black mb-4">Recommended Products</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mb-3 gap-4">
            @foreach ($related_products as $related_product)
                @if($related_product)
                    @include('front.layouts.product-loop2', [
                        'product' => $related_product
                    ])
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script src="{{asset('js/jquery.fitvids.js')}}"></script>
    <script>
        $(document).ready(function(){
            $(".responsive_video").fitVids();
        });
    </script>

    @if(env('APP_FB_TRACK'))
    <script>
        fbq('track', 'ViewContent', {
            value: '{{$product->prices["sale_price"]}}',
            currency: 'BDT',
            content_ids: '{{$product->id}}',
            content_type: 'product',
        });
    </script>
    @endif

    @if(Info::Settings('fb_api', 'track') == 'Yes')
    <script>
        // FB Conversion Track(PageView)
        $(window).on('load', function() {
            $.ajax({
                type: "POST",
                url: "{{ route('fbTrack') }}",
                data: {
                    _token: '{{csrf_token()}}',
                    track_type: 'ViewContent',
                    data: {
                        value: '{{$product->prices["sale_price"]}}',
                        currency: 'BDT',
                        content_ids: '{{$product->id}}',
                        content_type: 'product',
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

    <script>

        // Get Variable price
        $(document).on('change', '.co_radio', function () {
            // Get Data
            let product = "{{$product->id}}";
            let attribute_values = $("input.co_radio:checked").map(function () {
                return $(this).val();
            });

            let values = attribute_values.get();
            values = values.sort();

            // Ajax Action
            $.ajax({
                url: "{{route('product.variationPrice')}}",
                method: "POST",
                data: {values, product, _token: "{{csrf_token()}}"},
                dataType: "JSON",
                success: function (result) {
                    if(result.status == true){
                        // $('.add_to_cart').removeClass('disabled');
                        // $('.no_stock_alert').hide();
                        $('.single_product_price').html(result.sale_price);
                        $('.product_data_id').val(result.product_data_id);
                        // $('.maximum_stock').val(result.stock);
                        // $('.cart_quantity_input').val(1);
                    }else{
                        $('.product_data_id').val('');
                    }

                    // if(result.sku){
                    //     $('.sku_code').html(result.sku);
                    // }else{
                    //     $('.sku_code').html('N/A');
                    // }
                },
                error: function (){
                    console.log('Variation price ajax error!');
                }
            });
        });
    </script>
@endsection
