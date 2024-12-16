<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if(request()->getHost() == 'teddybearbd.com')
    <link data-n-head="ssr" rel="icon" type="image/x-icon" href="{{asset('img/teddy-favicon.png')}}">
    @else
    <link data-n-head="ssr" rel="icon" type="image/x-icon" href="https://cutpricebd.com/img/favicon.jpeg">
    @endif

    @yield('head')

    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        .dynamic_style h1, .dynamic_style h2, .dynamic_style h3, .dynamic_style h4, .dynamic_style h5, .dynamic_style h6 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        }

        .dynamic_style h1 {
        font-size: 2.5rem;
        }

        .dynamic_style h2 {
        font-size: 2rem;
        }

        .dynamic_style h3 {
        font-size: 1.75rem;
        }

        .dynamic_style h4 {
        font-size: 1.5rem;
        }

        .dynamic_style h5 {
        font-size: 1.25rem;
        }

        .dynamic_style h6 {
        font-size: 1rem;
        }

        .dynamic_style ol,
        .dynamic_style ul,
        .dynamic_style dl {
        margin-top: 0;
        margin-bottom: 1rem;
        }

        .dynamic_style ol ol,
        .dynamic_style ul ul,
        .dynamic_style ol ul,
        .dynamic_style ul ol {
        margin-bottom: 0;
        }

        .dynamic_style ul{display: block;
        list-style-type: disc;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;}

        .dynamic_style ol{    display: block;
        list-style-type: decimal;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;}
    </style>
</head>
<body>
    @yield('master')

    <a target="_blank" href="https://api.whatsapp.com/send?phone={{request()->getHost() == 'teddybearbd.com' ? '01784222266' : '8801784222266'}}&text={{url()->current()}}&" class="fixed bottom-12 md:bottom-8 right-2 md:right-8 bg-green-600 hover:bg-green-700 text-white fill-current p-2 rounded-full shadow-lg inline-block z-40"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-10 h-10"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg></a>

    <footer class="border-t mt-10 pt-10 pb-6 text-center bg-gray-100">
        <div class="container">
            <h3 class="text-xl font-semibold">See all our Products in</h3>
            <ul class="mb-5">
                <li class="inline-block px-1 md:px-4" target="_blank"><a class="text-300 hover:text-green-800 underline" href="https://cutpricebd.com/en/category/44/leather-jacket-winter-collections">Jackets</a></li>
                <li class="inline-block px-1 md:px-4" target="_blank"><a class="text-300 hover:text-green-800 underline" href="https://cutpricebd.com/bn/category/512/baby-food-collection">Baby Foods</a></li>
                <li class="inline-block px-1 md:px-4" target="_blank"><a class="text-300 hover:text-green-800 underline" href="https://cutpricebd.com/bn/category/515/all-chocolates">Chocolates</a></li>
                <li class="inline-block px-1 md:px-4" target="_blank"><a class="text-300 hover:text-green-800 underline" href="https://cutpricebd.com/en/category/69/jewelry">Cosmetics</a></li>
            </ul>

            <h3 class="text-xl font-semibold">Useful Links</h3>
            <ul class="mb-5">
                <li class="inline-block px-4" target="_blank"><a class="text-300 hover:text-green-800 underline" href="https://cutpricebd.com/bn/return-refund">Refund policy</a></li>
                <li class="inline-block px-4" target="_blank"><a class="text-300 hover:text-green-800 underline" href="https://cutpricebd.com/bn/privacy-policy">Privacy policy</a></li>
                <li class="inline-block px-4" target="_blank"><a class="text-300 hover:text-green-800 underline" href="https://cutpricebd.com/bn/tnc">Terms of service</a></li>
            </ul>

            <p class="text-gray-800 mb-0 pb-6">© {{date('Y')}} All Rights Reserved || Developed by <a href="https://eomsbd.com" class=" hover:text-green-800 underline">Best Ecommerce Developer</a>.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    @yield('footer')
</body>
</html>
