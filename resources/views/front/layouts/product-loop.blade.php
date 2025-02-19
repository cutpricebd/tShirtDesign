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
        <div class="" style="min-height: 4rem !important;">
            <a href="{{ $product->route }}">
                <h3 class="text-md font-serif uppercase hover:scale-110 duration-300">{{$product->title}}</h3>
            </a>
            <div class="flex justify-center">
                <p class="text-md text-primary font-semibold hover:scale-110 duration-300">{{ $settings_g['currency_symbol'] ?? '৳' }} {{$product->sale_price}}</p>
                @if($product->regular_price && $product->regular_price > $product->sale_price)
                    <p class="text-sm text-gray-400 line-through" style="margin-left: 5px;margin-top: 2px;">{{ $settings_g['currency_symbol'] ?? '৳' }} {{$product->regular_price}}</p>
                @endif
            </div>
        </div>
        <div class="mt-auto">
            <a href="{{route('cart.directOrder', ['product' => $product->id])}}" class="rounded-md block py-1 text-center text-white bg-[#b13481] hover:scale-110 hover:overflow-hidden duration-200">Add to Cart</a>
        </div>
    </div>
</div>

