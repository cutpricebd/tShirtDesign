<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @foreach ($products as $product_data)
    {{-- {{dd($product_data->img_paths)}} --}}
        <div class="mb-2 md:mb-4 single_product_wrap">
            <div class="border-pink-700 border p-3 rounded-md">
                <div class="shadow-md rounded-md product_preview">
                    <img src="{{$product_data->img_paths['original']}}" alt="{{$product_data->name}}" width="300" height="160" class="w-full h-auto object-center image">

                    @if(isset($product_data->others_data_arr['video_embed_code']) && $product_data->others_data_arr['video_embed_code'])
                    <div class="aspect-w-16 aspect-h-9 video" style="display: none">
                        {!! $product_data->others_data_arr['video_embed_code'] !!}
                    </div>
                    @endif
                </div>

                @if(isset($product_data->others_data_arr['video_embed_code']) && $product_data->others_data_arr['video_embed_code'])
                <div class="text-center mt-3 text-xl">
                    <h2 class="cursor-pointer text-green-700 hover:text-green-800 changeImage" data-type="video">এই প্রোডাক্টের ভিডিও দেখতে ক্লিক করুন</h2>
                </div>
                @endif

                <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-2 mt-4 justify-center">
                    @foreach ($product_data->Gallery as $product_image)
                        <div class="block shadow cursor-pointer hover:shadow-lg">
                            <img src="{{$product_image->paths['small']}}" data-type="image" data-image="{{$product_image->paths['original']}}" alt="{{$product_data->name}}" width="80" height="80" class="w-full h-24 object-center object-cover rounded-md border border-pink-700 changeImage">
                        </div>
                    @endforeach

                    @if(isset($product_data->others_data_arr['video_embed_code']) && $product_data->others_data_arr['video_embed_code'])
                    <div class="block shadow cursor-pointer hover:shadow-lg">
                        <img src="https://cutpricebd.com/img/video-thumb.webp" data-type="video" width="80" height="80" alt="Youtube Thumbnail" class="w-full h-24 object-center object-cover changeImage">
                    </div>
                    @endif
                    {{-- @if(isset($product->others_arr['videos']))
                        @foreach ($product->others_arr['videos'] as $video)
                            <div class="block shadow cursor-pointer hover:shadow-lg">
                                <img src="{{$video['img_path']}}" data-video="{{$video['id']}}" alt="{{$product_data->name}}" width="80" height="80" class="w-full h-24 object-center object-cover rounded-md border border-pink-700">
                            </div>
                        @endforeach
                    @endif --}}
                </div>

                <h3 class="font-medium mt-2 text-2xl">{{$product_data->name}} <span class="product_attr_string_title">{{(request()->getHost() == 'teddybearbd.com') ? '(2.5 Feet)' : ''}}</span></h3>
                <p class="text-2xl text-gray-700 mb-4"><span class="single_price">{{$product_data->first_price}}</span> টাকা <span class="text-gray-400 line-through text-xl"><span class="single_old_price">{{$product_data->old_price}}</span> টাকা</span></p>

                {{-- <div>
                    @foreach ($attributes as $attribute)
                        @if($attribute->attribute_data->name == 'Color' || $attribute->attribute_data->name == 'colour' || $attribute->attribute_data->name ==  'Colour')
                            <div class="mb-8">
                                <h3 class="text-sm text-gray-900 font-medium">Color</h3>
                                <fieldset class="mt-1">
                                    <legend class="sr-only">Choose a Color</legend>

                                    <div class="flex items-center space-x-3">
                                        @foreach ($attribute->attribute_values as $attribute_value)
                                            <label for="variation_val_{{$attribute_value->id}}" class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-gray-400 active:ring ring-offset-1">
                                                <input type="radio" aria-labelledby="color-choice-0-label" name="attribute_id_{{$attribute->attribute_data->id}}" id="variation_val_{{$attribute_value->id}}" class="sr-only product_variations" value="{{$attribute_value->id}}">

                                                <span aria-hidden="true" class="h-8 w-8 bg-white border border-gray-600 rounded-full" style="background-color: #{{$attribute_value->data_arr[1] ?? '000000'}};"></span>
                                            </label>
                                        @endforeach
                                    </div>
                                </fieldset>
                            </div>
                        @else
                            @php
                                if(request()->getHost() == 'teddybearbd.com'){
                                    $is_last_checked = true;
                                }else{
                                    $is_last_checked = false;
                                }
                            @endphp
                            <div class="mb-8">
                                <h3 class="text-sm text-gray-900 font-medium">{{$attribute->attribute_data->name}}</h3>
                                <fieldset class="mt-1">
                                    <legend class="sr-only">Choose a {{$attribute->attribute_data->name}}</legend>
                                    <div class="grid grid-cols-6 md:grid-cols-8 gap-1 md:gap-4">
                                        @foreach ($attribute->attribute_values as $attribute_value)
                                        <label for="variation_val_{{$attribute_value->id}}" class="group relative border rounded-md py-1.5 px-2 flex items-center justify-center text-sm font-medium text-center hover:bg-gray-50 focus:outline-none sm:flex-1 bg-white shadow-sm text-gray-900 cursor-pointer">
                                            <input type="radio" aria-labelledby="size-choice-1-label" name="attribute_id_{{$attribute->attribute_data->id}}" id="variation_val_{{$attribute_value->id}}" class="sr-only product_variations" value="{{$attribute_value->id}}" {{($is_last_checked && (($loop->index + 1) == count($attribute->attribute_values))) ? 'checked' : ''}}>
                                            {{$attribute_value->value}}
                                            <span aria-hidden="true" class="absolute -inset-px rounded-md pointer-events-none"></span>
                                        </label>
                                        @endforeach
                                    </div>
                                </fieldset>
                            </div>
                        @endif
                    @endforeach
                </div> --}}

                <div class="grid grid-cols-4 gap-2">
                    <div class="col-span-3">
                        <button data-scroll-nav="2" type="button" class="bg-pink-600 border border-transparent rounded-md py-2 px-2 md:px-4 items-center justify-center text-base font-medium text-white hover:bg-primary-light focus:outline-none focus:ring-2 focus:ring-offset-2 block md:inline-block w-full kinun_btn2" data-id="{{$product_data->id}}" data-image="{{$product_data->img_paths['small']}}" data-title="{{$product_data->name}}" data-oldprice="{{$product_data->old_price}}" data-price="{{$product_data->first_price}}" data-attr="">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path></svg>
                            এখনি কিনুন
                        </button>
                    </div>

                    <div>
                        <a href="https://api.whatsapp.com/send?phone=8801784222266&text=https://cutpricebd.com/product/{{$product_data->slug}}/{{$product_data->id}}&" target="_blank" class="bg-pink-600 border border-transparent rounded-md py-2 px-2 md:px-4 items-center justify-center text-base font-medium text-white hover:bg-primary-light focus:outline-none focus:ring-2 focus:ring-offset-2 block w-full text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6 text-white inline-block"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
