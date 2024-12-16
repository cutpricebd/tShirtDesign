@extends('front.layouts.master')

@section('head')
    @include('meta::manager', [
        'title' => $category->title . ' - ' . ($settings_g['title'] ?? env('APP_NAME')),
        'image' => $category->media_id ? $category->img_paths['medium'] : null,
        'description' => $category->meta_description,
        'keywords' => $category->meta_tags
    ])
    <style>
        /* Default background color for the accordion button */
        #accordion-open .flex.items-center {
            background-color: #ff64c3de; /* Set your desired default color */
        }

        /* Background color when the accordion is collapsed */
        #accordion-open .flex.items-center[aria-expanded="false"] {
            background-color: #ff64c3de; /* Set your desired collapsed color */
        }

        /* Background color when the accordion is expanded */
        #accordion-open .flex.items-center[aria-expanded="true"] {
            background-color: #ff64c3de; /* Set your desired expanded color */
        }
    </style>
@endsection

@section('master')
 @include('front.layouts.breadcrumb', [
    'title' => $category->title,
    'url' => "category/$category->slug"
])

{{--old category don remove--}}
{{--<div id="banner" class="relative w-full h-48 xs:h-64 sm:h-72 md:h-96 lg:h-[500px] my-4 overflow-hidden rounded-lg">
    <div id="banner_img" class="absolute inset-0 transition-transform duration-500 ease-in-out scale-100">
        <img alt="{{$category->title}}" fetchpriority="high" decoding="async" data-nimg="fill" class="rounded-lg z-0"
             style="position: absolute;height: 100%;width: 100%;left: 0;top: 0;right: 0;bottom: 0;object-fit: cover;color: transparent;"
             sizes="100vw" src="{{asset("uploads/$category->banner_image")}}" />
    </div>
    <div id="banner_opacity" class="absolute inset-0 transition-all duration-500 ease-in-out bg-black bg-opacity-10"></div>
    <div id="banner_title" class="absolute inset-0 flex items-center justify-center transition-opacity duration-500 ease-in-out opacity-0">
        <h1 class="text-white text-2xl xs:text-3xl sm:text-4xl md:text-4xl lg:text-5xl font-bold uppercase">
            {{$category->title}}
        </h1>
    </div>
</div>--}}
{{--<div class="py-8 bg-gray-200">
    <div class="flex justify-between items-center px-4">
        <h2 class="text-2xl font-bold text-[#b13481] ml-4 uppercase">{{$category->title}}</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6 px-4">
        @foreach ($products as $product)
            @if($product)
                @include('front.layouts.product-loop', [
                    'product' => $product
                ])
            @endif
        @endforeach
        <div class="my-6 mb-8">
            {{$products->links('pagination::tailwind')}}
        </div>
    </div>
</div>--}}
 <input type="hidden" id="category_id_unq" value="{{ $category->id }}">

<div class="py-8 bg-transparent">
    <div class="grid grid-cols-5 px-2">
        <div class="border-red-500">
            <div>Showing 1-20 out of {{ count($products)  }} products</div>

            <div id="accordion-open" data-accordion="open">
                <h2 id="accordion-collapse-heading-2">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 gap-3" data-accordion-target="#accordion-collapse-body-2" aria-expanded="true" aria-controls="accordion-collapse-body-2">
                        <span>Category</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                    <div class="p-5 border border-gray-200">
                        <ul>
                            @foreach($categories as $category)
                                <li><a href="{{ route('category',$category->slug) }}">{{ $category->title }} ({{ $category->Products->count()  }})</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @foreach($attributes as $key=>$attribute)
                    <h2 id="accordion-collapse-heading-{{$key}}">
                        <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 gap-3" data-accordion-target="#accordion-collapse-body-{{$key}}" aria-expanded="true" aria-controls="accordion-collapse-body-{{$key}}">
                            <span>{{ $attribute->name }}</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-{{$key}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$key}}">
                        <div class="p-5 border border-gray-200">
                            <ul class="flex sp_variation_all grid grid-cols-3 gap-2">
                                @foreach($attribute->AttributeItems as $key2=>$atb)
                                    <li class="">
                                        <input type="radio" name="attr_id_{{$key}}" id="atb_id_{{$key}}{{$key2}}" class="co_radio" value="{{ $atb->id }}">
                                        <label for="atb_id_{{$key}}{{$key2}}" class="cartOptions">{{ $atb->name }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
        <div class="col-span-4  category_section" id="category_section_unique">
            @include('front.layouts.categoryProduct',['products'=>$products])
        </div>
    </div>
</div>
<div class="container flex flex-col md:flex-row gap-8 px-4 py-8 mx-auto">
    <div class="bg-[#bfbfbf] p-6 rounded-lg flex flex-col justify-between w-full md:w-1/2">
        <div>
            <h2 class="text-3xl md:text-5xl font-semibold mb-4 font-medium">Discover Your Perfect Look Today!</h2>
            <p class="mb-6 text-xl md:text-base">
                Explore Rabia's Collection for exquisite Indian fashion. Whether it's <br />
                elegant sarees, glamorous lehengas, stylish kurtas, or adorable kids <br />
                wear, find your statement piece for every occasion. Start your<br />
                journey now and embrace timeless elegance.
            </p>
        </div>
        <div class="flex gap-4">
            <button class="bg-cover bg-center text-white py-2 px-4 sm:px-2 sm:py-1 rounded-md font-semibold bg-[#fe64c2] font-mono">Shop Now</button>
            <button class="border border-black py-2 px-4 sm:px-2 sm:py-1 rounded-md font-semibold">Discover Collection</button>
        </div>
    </div>
    <div class="relative w-full md:w-1/2 aspect-w-4 aspect-h-3 bg-cover bg-center rounded-lg" style="background-image: url('/img/NewsletterImg.jpg')">
        <div class="p-6 h-full flex flex-col justify-between bg-black bg-opacity-20">
            <div>
                <a href="{{route('homepage')}}" class="absolute" style="top: 10px;right: 20px;">
                    <img loading="lazy" width="70" height="70" decoding="async" data-nimg="1" class="rounded-full" style="color:transparent" src="{{$settings_g['logo'] ?? ''}}" alt="{{$settings_g['title'] ?? env('APP_NAME')}}">
                </a>
                <div class="absolute" style="bottom: 20px;left: 20px; width: 93%">
                    <p class="text-white text-3xl md:text-5xl mb-2 text-center md:text-left font-medium">Join our <br>Newsletter</p>
                    <div class="relative">
                        <input type="email" placeholder="Your email address" class="w-full py-2 sm:py-1 px-4 sm:px-2 rounded-md text-gray-700 bg-transparent border-white border-2 " />
                        <button class="absolute right-0 bg-white rounded-full text-black px-4 text-md sm:px-2 mr-4" style="width: 25px; height: 25px; top: 5px;">
                            <svg style=" margin-left: -3px;" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-[#e8e8e8] p-4 md:p-8 lg:p-16">
    <h2 class="text-3xl md:text-5xl mb-8 mx-4 md:mx-8 text-center md:text-left font-medium">COUPONS CORNER</h2>
    <div class="flex flex-col md:flex-row md:space-x-8 mb-4 mx-4 md:mx-10 space-y-4 md:space-y-0">
        <div class="w-full md:w-1/2 bg-cover bg-center h-48 md:h-64 rounded-lg animate-pulse" style="background-image: url('/img/Couponimage1.jpg')"></div>
        <div class="w-full md:w-1/2 bg-cover bg-center h-48 md:h-64 rounded-lg animate-pulse" style="background-image: url('/img/Couponimage2.jpg')"></div>
    </div>
</div>
@endsection
@section('footer')
<script>
    $("#banner").hover(
        function(){
            $("#banner_img").removeClass('scale-100').addClass('scale-105');
            $("#banner_opacity").removeClass('bg-opacity-10').addClass('bg-opacity-60');
            $("#banner_title").removeClass('opacity-0').addClass('opacity-100');
        }, function(){
            $("#banner_img").removeClass('scale-105').addClass('scale-100');
            $("#banner_opacity").removeClass('bg-opacity-60').addClass('bg-opacity-10');
            $("#banner_title").removeClass('opacity-100').addClass('opacity-0');
        }
    );
</script>
<script>
    // Get Variable price
    $(document).on('change', '.co_radio', function () {
        // Get Data
        let attribute_values = $("input.co_radio:checked").map(function () {
            return $(this).val();
        });
        let category_id = $('#category_id_unq').val();
        let values = attribute_values.get();
        values = values.sort();
        // Ajax Action
        $.ajax({
            url: "{{route('product.filterCategory')}}",
            method: "POST",
            data: {values, category_id, _token: "{{csrf_token()}}"},
            dataType: "JSON",
            success: function (result) {
                $('#category_section_unique').html(result.html)
            },
            error: function (){
                console.log('Variation price ajax error!');
            }
        });
    });
</script>


@endsection
