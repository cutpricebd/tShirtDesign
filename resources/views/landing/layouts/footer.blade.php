<div data-scroll-index="1">
    <div class="border-yellow-300 border-2 rounded">
        <h2 class="text-2xl md:text-4xl bg-yellow-300 text-center py-2 font-bold px-1">✨সমগ্র বাংলাদেশে ক্যাশ অন ডেলিভারি দেয়া হয়।🔆</h2>
        <div class="p-3">
            <p class="mb-1">অর্ডার করার জন্যঃ</p>
            <ul class="md:px-5 mb-2">
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনার নাম</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">প্রোডাক্টের কোড বা ছবি অথবা স্ক্রিনসট,</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">প্রোডাক্ট সাইজ</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনার মোবাইল নাম্বার, এবং</span></li>
                <li class="text-xl overflow-hidden mb-1"><img class="check_image inline-block mr-2 float-left" src="{{asset('landing/2705.svg')}}" alt="check"> <span class="float-left list_text">আপনার ঠিকানা।</span></li>
            </ul>
            <p class="mb-1">পাঠিয়ে দিন আমাদের <a href="https://api.whatsapp.com/send?phone={{$landing->mobile_number ?? '8801784222266'}}&text={{url()->current()}}&" target="_blank" class="text-green-800 underline"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 inline-block"><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg> WhatsApp</a> ইনবক্সে।</p>
        </div>
    </div>

    @if(($landing->type ?? 'general') != 'editable')
    <div class="shadow border-2 border-yellow-300 rounded mb-5 mt-5">
        <h2 class="text-2xl md:text-4xl bg-yellow-300 text-center py-2 font-bold px-1">মূল্য তালিকাঃ</h2>

        <div class="p-3">
           <table class="border-collapse table-auto w-full text-sm mb-4">
              <thead>
                 <tr class="border-t border-l">
                    <th class="border-b border-r px-2 py-1 text-left">Product</th>
                    <th class="border-b border-r px-2 py-1 text-left">Price</th>
                    <th class="border-b border-r px-2 py-1 text-left">Action</th>
                 </tr>
              </thead>
              <tbody class="bg-white">
                @foreach ($metas as $meta)
                    <tr class="border-t border-l">
                        <td class="border-b border-r px-2 py-1">
                            @if($product->id == 377 && $meta->product_id == 377)
                            <p class="product_title" data-id="{{$product->id}}">{{$product->name}}</p>
                            @elseif($product->id == 38458 && $meta->product_id == 38458)
                            <p class="product_title" data-id="{{$product->id}}">{{str_replace('( yellow + pink + blue + black + marun + Ash color)', '', $product->name)}}</p>
                            @elseif($product_2 && $meta->product_id == $product_2->id)
                            <p class="product_title" data-id="{{$product_2->id}}">{{$product_2->name}}</p>
                            @endif

                            <input type="hidden" name="meta[]" value="">
                            <input type="hidden" name="product_id[]" value="{{$product->id}}">
                            <input type="hidden" name="variation[]" value="">

                            <span>
                                {{$meta->attribute_string_json ?? ''}}</span>
                                @if($meta->image)
                                    <a href="{{str_replace('https://eoms.cutpricebd.com/oms_products/small/', 'https://eoms.cutpricebd.com/oms_products/big/', str_replace('https://eoms.cutpricebd.com/oms_products/thumbs/', 'https://eoms.cutpricebd.com/oms_products/big/', $meta->image))}}" target="_blank"><img src="{{$meta->image}}" alt="{{$meta->attribute_string_json ?? ''}}" width="80" height="80" class="h-16 object-center object-cover"></a>
                                @endif
                            @if($meta->note)
                            <p class="text-xs text-red-400">{{$meta->note}}</p>
                            @endif
                        </td>
                        <td class="border-b border-r px-2 py-1">
                            {{$meta->selling_price}} টাকা
                            @if($meta->old_price)
                            <p class="text-sm text-gray-400 line-through">{{$meta->old_price}} টাকা</p>
                            @endif
                        </td>
                        <td class="border-b border-r px-2 py-1">
                            <button data-scroll-nav="2" type="button" class="bg-green-800 hover:bg-green-700 border border-transparent rounded-md py-1 px-2 items-center justify-center text-white kinun_btn" data-id="{{$meta->id}}" data-image="{{$meta->image ?? $product->default_image['small']}}" data-variation="{{$meta->attribute_string_json ?? ''}}" data-price="{{$meta->selling_price}}" data-oldprice="{{$meta->old_price}}" data-product_id="{{$product->id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                                </svg>
                                কিনুন
                            </button>
                        </td>
                    </tr>
                @endforeach
           </table>
        </div>
    </div>
    @endif
</div>

@include('landing.layouts.order-form')

@if(count($reviews))
<div class="mt-5">
    @foreach ($reviews as $review)
        <article class="bg-gray-100 mb-4 py-4 px-3 rounded">
            <div class="flex items-center mb-4 space-x-4">
            <img height="40" width="40" src="https://cutpricebd.com/img/user-image.webp" alt="User Icon" class="w-10 h-10 rounded-full">
            <div class="space-y-1 font-medium">
                <p>
                    {{$review->user_name}}
                    <span class="text-xs block text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                        </svg>
                        Verified Purchase
                    </span>
                    <time datetime="2014-08-16 19:00" class="block text-xs text-gray-500">{{$review->date}}</time>
                </p>
            </div>
            </div>
            <div class="flex items-center mb-1">
                @include('landing.layouts.rating', [
                    'rating' => $review->rating
                ])
            </div>
            <p class="mb-2 font-light text-gray-500">{{$review->review}}</p>
            @if($review->img_path)
            <a href="{{$review->img_path}}" target="_blank" class="inline-block"><img src="{{$review->img_small_path}}" alt="product review" class="w-24"></a>
            @endif
        </article>
    @endforeach
</div>
@endif

@if(count($related_products))
<div class="grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-5 md:gap-4 mb-5">
    @foreach ($related_products as $related_product)
        <div class="bg-white shadow rounded overflow-hidden">
            <a href="https://cutpricebd.com/bn/product/{{$related_product->slug}}/{{$related_product->id}}" class="relative block group">
            <img src="{{$related_product->default_image['thumbs']}}" alt="{{$related_product->name}}" width="170" height="210" class="w-full h-52 object-contain">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                <div class="text-white text-lg w-9 h-9 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </a>
        <div class="pt-4 pb-3 px-4">
            <a href="https://cutpricebd.com/bn/product/{{$related_product->slug}}/{{$related_product->id}}" class="">
                <h4 class="font-medium text-md mb-2 text-gray-800 hover:text-primary transition h-12 overflow-hidden">{{$related_product->name}}</h4>
            </a>
            <div class="flex items-baseline mb-1 space-x-2">
                <p class="text-xl text-primary font-semibold">{{$related_product->first_price}} টাকা</p>
                @if($related_product->old_price)
                <p class="text-sm text-gray-400 line-through">{{$related_product->old_price}} টাকা</p>
                @endif
            </div>
            <div class="flex items-center">
                @include('landing.layouts.rating', [
                    'rating' => $related_product->rating
                ])

                <div class="text-xs text-gray-500 ml-3">({{$related_product->review_count}})</div>
            </div>
        </div>
        <a href="https://cutpricebd.com/bn/product/{{$related_product->slug}}/{{$related_product->id}}" class="block w-full py-1 text-center text-white bg-green-800 border-2 border-green-800 rounded-b hover:bg-transparent hover:text-black transition focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
            </svg>
            কিনুন
        </a>
        </div>
    @endforeach
</div>
@endif
