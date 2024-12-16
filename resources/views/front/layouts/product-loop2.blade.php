<div class="relative bg-white shadow-md rounded-lg w-full transition-all duration-300 hover:shadow-2xl">
    <div class="w-full relative mx-auto h-100 overflow-hidden rounded-t-lg">
        <a href="{{ $product->route }}">
            <img alt="{{$product->title}}" loading="lazy" width="800" height="400" decoding="async" data-nimg="1"
            class="w-full h-auto relative z-0 transition-all duration-300 hover:scale-110"
            style="color: transparent"
            src="{{$product->img_paths['medium']}}" />
        </a>
        <button class="absolute top-6 right-6 text-red-500 border-2 border-red-500 p-2 rounded-full bg-transparent">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z"></path>
            </svg>
        </button>
    </div>
    <div class="p-4 text-center">
        <div class="" style="min-height: 5rem !important;">
            <a href="{{ $product->route }}">
                <h3 class="text-md font-serif uppercase hover:scale-110 duration-300">{{$product->title}}</h3>
            </a>
            <p class="text-md text-primary font-semibold hover:scale-110 duration-300">{{ $settings_g['currency_symbol'] ?? '৳' }} {{$product->sale_price}}</p>
            @if($product->regular_price && $product->regular_price > $product->sale_price)
                <p class="text-sm text-gray-400 line-through">{{ $settings_g['currency_symbol'] ?? '৳' }} {{$product->regular_price}}</p>
            @endif
            {{--@if($product->type == "Simple")
                <p class="text-gray-500 text-sm hover:scale-110 duration-300">${{$product->sale_price}}</p>
            @elseif($product->type == "Variable")
                <p class="text-gray-500 text-sm hover:scale-110 duration-300">Starting From $29.99</p>
            @endif--}}
        </div>
    </div>
    <div class="mt-auto">
        <div class="my-3 flex px-2">
            @foreach(['black', 'white', 'red', 'blue', 'green', 'yellow'] as $key=>$color)
                <div class="flex items-center me-3">
                    <input id="'color_variant'{{$key}}" type="radio" value="at" name="color_variant" class="hidden peer">
                    <label for="'color_variant'{{$key}}" class="ms-2 cursor-pointer text-sm font-medium bg-transparent text-gray-900">
                        <div class="flex items-center">
                            <div class="z-10 flex items-center justify-center w-5 h-5 bg-gray-100 rounded-full ring-0 ring-gray-100
                    sm:ring-8 shrink-0" style="background-color: {{\Illuminate\Support\Str::lower($color) }}">
                                {{--<svg class="w-2.5 h-2.5 text-blue-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                </svg>--}}
                            </div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>

