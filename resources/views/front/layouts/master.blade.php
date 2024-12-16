<!DOCTYPE html>
@php
    $cart_summary = App\Repositories\CartRepo::summary();
    $main_menu = cache()->remember('main_menu', (60 * 60 * 24 * 90), function(){
        return App\Models\Menu::with('SingleMenuItems', 'SingleMenuItems.Page', 'SingleMenuItems.Category')->where('name', 'Main Menu')->first();
    });
    $footer_menu = cache()->remember('footer_menu_cache', (60 * 60 * 24 * 90), function(){
        return App\Models\Menu::with('SingleMenuItems', 'SingleMenuItems.Page', 'SingleMenuItems.Category')->where('name', 'Footer Menu')->first();
    });
    $top_menus = cache()->remember('top_menu_cache', (60 * 60 * 24 * 90), function(){
        return App\Models\Menu::with('SingleMenuItems', 'SingleMenuItems.Page', 'SingleMenuItems.Category')->where('name', 'Top Menu')->first();
    });
    $socials = cache()->remember('homepage_social', (60 * 60 * 24 * 90), function(){
        return Info::SettingsGroup('social');
    });
    // $categories = cache()->remember('homepage_categories', (60 * 60 * 24 * 90), function(){
    //     return App\Models\Product\Category::where('for', 'product')->where('category_id', null)->active()->select('id', 'title', 'slug')->get();
    // });
    $categories = App\Models\Product\Category::where('for', 'product')->where('category_id', null)->active()->select('id', 'title', 'slug')->get();
    $widgets = App\Models\Widget::with('Menu', 'Menu.SingleMenuItems')->where('status', 1)->where('placement', 'Footer')->orderBy('position')->get();

@endphp
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        :root {
          --primary: {{$settings_g['primary_color'] ?? "#c04000"}};
          --primary_light: {{$settings_g['primary_light_color'] ?? "#ff686e"}};
          --secondary:{{$settings_g['secondary_color'] ?? "#21cd9c"}};
          --secondary_dark:{{$settings_g['secondary_dark_color'] ?? "#047857"}};
        }
    </style>
    <!-- Icons -->
    <link rel="shortcut icon" href="{{$settings_g['favicon'] ?? ''}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/front/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.13.2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{asset('front/layout.css')}}" />
    <link rel="stylesheet" href="{{asset('front/page.css')}}" />
    <link rel="stylesheet" href="{{asset('front/custom.css')}}" />
    @yield('head')
    {!! $settings_g['custom_head_code'] ?? '' !!}
    <script>
        let base_url = "{{route('homepage')}}";
        let _token = '{{csrf_token()}}';

        function toggleMenu(){
            let mobile_menu = document.getElementById("mobile_menu");
            mobile_menu.classList.toggle('mobile_menu_hidden');
        }
    </script>
</head>
<body>
    {!! $settings_g['custom_body_code'] ?? '' !!}
    <div class="fixed top-0 left-0 bg-gray-500 bg-opacity-80 w-full h-full text-center z-50 pt-20 page_loader_hidden" id="page_loader">
        <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <div class="flex flex-col">
        <div>
            <nav class="shadow-sm fixed w-full z-10 bg-white">
                <div class="container mx-auto px-4 md:px-10 py-2 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div>
                            <a href="{{route('homepage')}}">
                                <img loading="lazy" width="70" height="70" decoding="async" data-nimg="1" class="rounded-full" style="color:transparent" src="{{$settings_g['logo'] ?? ''}}" alt="{{$settings_g['title'] ?? env('APP_NAME')}}">
                            </a>
                        </div>
                    </div>
                    <div id="top_menus" class="flex-grow justify-center hidden md:flex">
                        <div class="flex lg:space-x-4 space-x-2 md:space-x-3 uppercase">
                            @if(isset($top_menus->SingleMenuItems) && count($top_menus->SingleMenuItems))
                                @foreach($top_menus->SingleMenuItems as $menu_item)
                                    <a href="{{$menu_item->menu_info['url']}}" class="text-[.6rem] md:text-lg lg:text-2xl font-semibold relative text-gray-700 hover:text-black  cursor-pointer transition-all ease-in-out before:transition-[width] before:ease-in-out before:duration-500 before:absolute before:bg-[#ff65c1] before:origin-center before:h-[3px] before:w-0 hover:before:w-[50%] before:bottom-0 before:left-[50%] after:transition-[width] after:ease-in-out after:duration-500 after:absolute after:bg-[#ff65c1] after:origin-center after:h-[3px] after:w-0 hover:after:w-[50%] after:bottom-0 after:right-[50%]">{{$menu_item->menu_info['text']}}</a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div id="search_modal" class="flex-grow justify-center hidden md:flex" style="display: none;">
                        <div class="flex lg:space-x-4 space-x-2 md:space-x-3 uppercase" style="width: 80%;">
                            <form method="get" action="{{route('search')}}" class="relative w-full flex">
                                <input type="search" id="search-dropdown" name="search" class="block p-2 w-full h-12 z-20 text-lg text-gray-900 shadow-xl focus:primary " placeholder="Search" required="">
                                <img src="/img/close.png" alt="close" style="width: 20px;height: 20px;margin-top: 15px;margin-left: 5px;cursor: pointer;" id="search_form_close">
                              </form>
                        </div>
                    </div>
                    <div class="flex items-center lg:space-x-4 md:space-x-3 space-x-2">
                        <button class="hover:text-gray-400" id="search_icon">
                            <svg stroke="currentColor" fill="none" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="20" width="20"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <div>
                            <a href="{{route('cart')}}">
                                <button class="hover:text-gray-400">
                                    <svg stroke="currentColor" fill="none"
                                        stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                        height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                </button>
                            </a>
                            <span class="text-[#b13481]" ><?php echo $cart_summary['count'] > 0 ? $cart_summary['count'] : 0; ?></span>
                        </div>
                        <div>
                            <a href="#">
                                <button class="hover:text-gray-400">
                                    <svg stroke="currentColor" fill="none"
                                        stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                        height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                        </path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                        <a href="{{route('login')}}">
                            <button class="hover:text-gray-400">
                                <svg
                                    stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round" height="20" width="20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </button>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="flex-grow">
            <main class="w-full overflow-x-auto">
                <div class="mx-2">
                    <div class="mt-20">
                        <nav class="shadow-lg bg-white">
                            <div class="hidden md:flex justify-center items-center py-4 md:space-x-4 lg:space-x-8 uppercase">
                                @foreach($categories as $categorie)
                                    @if($categorie)
                                        <a class="sm:text-xs md:text-sm lg:text-lg font-semibold relative text-gray-700 hover:text-black  cursor-pointer transition-all ease-in-out before:transition-[width] before:ease-in-out before:duration-500 before:absolute before:bg-[#ff65c1] before:origin-center before:h-[3px] before:w-0 hover:before:w-[50%] before:bottom-0 before:left-[50%] after:transition-[width] after:ease-in-out after:duration-500 after:absolute after:bg-[#ff65c1] after:origin-center after:h-[3px] after:w-0 hover:after:w-[50%] after:bottom-0 after:right-[50%]" href="{{ url('') }}/category/{{$categorie->slug}}">
                                            {{$categorie->title}}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            <div class="md:hidden flex justify-between items-center px-4 py-2">
                                <button class="focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                                </button>
                            </div>
                            <div class="md:hidden flex flex-col items-center space-y-4 uppercase py-4">
                                @foreach($categories as $categorie)
                                    @if($categorie)
                                        <a class="sm:text-xs md:text-sm lg:text-lg font-semibold relative text-gray-700 hover:text-black  cursor-pointer transition-all ease-in-out before:transition-[width] before:ease-in-out before:duration-500 before:absolute before:bg-[#ff65c1] before:origin-center before:h-[3px] before:w-0 hover:before:w-[50%] before:bottom-0 before:left-[50%] after:transition-[width] after:ease-in-out after:duration-500 after:absolute after:bg-[#ff65c1] after:origin-center after:h-[3px] after:w-0 hover:after:w-[50%] after:bottom-0 after:right-[50%]" href="{{ url('') }}/category/{{$categorie->slug}}">
                                            {{$categorie->title}}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </nav>
                    </div>

                    @yield('master')

                        {{-- <footer class="bg-[#3d3b40] text-white py-10 rounded-md text-sm mb-4 mx-2">
                            <div class="container grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="mx-8">
                                    <img alt="Company Logo" loading="lazy" width="80" height="70" decoding="async"
                                        data-nimg="1" style="color:transparent"
                                        src="{{$settings_g['logo'] ?? ''}}" alt="{{$settings_g['title'] ?? env('APP_NAME')}}">
                                    <p class="mt-4 w-1/2">{{$settings_g['short_description']}}</p>
                                    <div class="flex space-x-4 mt-4">
                                        <a href="https://facebook.com" aria-label="Facebook" class="bg-white text-black rounded-full px-1 pt-1 hover:text-gray-400 hover:scale-110 duration-300">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512"
                                                height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="https://instagram.com" aria-label="Instagram" class="hover:text-gray-400 hover:scale-110 duration-300">
                                            <svg stroke="currentColor"
                                                fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="24"
                                                width="24" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="https://linkedin.com" aria-label="LinkedIn" class="bg-white text-black p-1 rounded-sm hover:text-gray-400 hover:scale-110 duration-300">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                                                height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="https://twitter.com" aria-label="X" class="hover:text-gray-400 hover:scale-110 duration-300">
                                            <svg stroke="currentColor"
                                                fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="23"
                                                width="23" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                    <p class="mt-10 text-sm">All Right Reserved. © 2024 Rabia's Collection</p>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mx-8">
                                    @foreach($widgets as $widget)
                                        <div>
                                            <h3 class="text-lg font-semibold mb-4 uppercase">{{$widget->title}}</h3>
                                            @if($widget->type == 'Menu' && $widget->Menu)
                                                <ul class="space-y-2">
                                                    @foreach ($widget->Menu->SingleMenuItems as $item)
                                                        <li><a href="{{$item->menu_info['url']}}" class="hover:text-gray-400">{{$item->menu_info['text']}}</a></li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div>
                                                    {!! $widget->text !!}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </footer> --}}
                </div>
            </main>
        </div>
    </div>

    <a target="_blank" href="https://api.whatsapp.com/send?phone={{$settings_g['mobile_number'] ?? ''}}&text={{url()->current()}}&" class="fixed bottom-14 md:bottom-8 right-2 md:right-8 bg-green-600 hover:bg-green-700 text-white fill-current p-2 rounded-full shadow-xl inline-block z-50">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-10 h-10"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg>
    </a>


    @if(Route::is('homepage'))
    @vite('resources/front/js/app.js')
    @endif
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.13.2/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{asset('front/custom.js')}}"></script>
    @if(session('success-alert'))
    <script>
        cAlert('success', "{{session('success-alert')}}");
    </script>
    @endif
    @if(session('error-alert'))
    <script>
        cAlert('error', "{{session('error-alert')}}");
    </script>
    @endif
    <script>
        function addToCart(product_id){
            let single_cart_quantity = $('#single_cart_quantity').val();
            $.ajax({
                url: '{{route("cart.add")}}',
                method: 'POST',
                dataType: 'JSON',
                data: {_token: '{{csrf_token()}}', product_id, quantity: single_cart_quantity},
                success: function(result){
                    cAlert('success', "Card added success!");
                    $('.top_cart_count').html(result.cart_count);
                },
                error: function(){
                    cAlert('success', "Something wrong!");
                }
            });
        }
        $("#search_icon").click(function() {
            $("#search_modal").show();
            $("#top_menus").hide();
            $("#search_icon").hide();
        });
        $("#search_form_close").click(function() {
            $("#search_modal").hide();
            $("#top_menus").show();
            $("#search_icon").show();
        });


    </script>
    @yield('footer')
    @if(Info::Settings('fb_api', 'track') == 'Yes')
    <script>
        // FB Conversion Track(PageView)
        $(window).on('load', function() {
            $.ajax({
                type: "POST",
                url: "{{ route('fbTrack') }}",
                data: {
                    _token: '{{csrf_token()}}',
                    track_type: 'PageView'
                },
                success: function (response) {
                    if(response == 'true'){
                        console.log('FB Tracked!');
                    }else{
                        console.log('FB Tracked Failed');
                    }
                },
                error: function(){
                    console.log('FB Tracked Error!');
                }
            });
        });
    </script>
    @endif
    {!! $settings_g['custom_footer_code'] ?? '' !!}
</body>
</html>
