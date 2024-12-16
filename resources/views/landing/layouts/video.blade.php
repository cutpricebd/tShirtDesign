<h2 class="text-xl md:text-4xl bg-yellow-300 text-center py-2 font-bold px-1 rounded mb-4">আগে ভিডিও দেখে তারপর অর্ডার করুন!</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 border p-2">
    @foreach ($product->others_arr['videos'] as $video)
    <div class="border p-2 responsive_video">
        <iframe width="360" height="315" src='https://www.youtube.com/embed/{{$video['id']}}?controls=0&rel=0&playsinline=0&modestbranding=0&autoplay=0&enablejsapi=1' title='' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' class='lazy' allowfullscreen='1'></iframe>

        <div class="text-center">
            <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-1 text-xl font-bold">
                এখনি কিনুন

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
                </svg>
            </a>
        </div>
    </div>
    @endforeach

    @if($product_2 && isset($product_2->others_arr['videos']) && count($product_2->others_arr['videos']))
    @foreach ($product_2->others_arr['videos'] as $video)
    <div class="border p-2 responsive_video">
        <iframe width="360" height="315" src='https://www.youtube.com/embed/{{$video['id']}}?controls=0&rel=0&playsinline=0&modestbranding=0&autoplay=0&enablejsapi=1' title='' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' class='lazy' allowfullscreen='1'></iframe>

        <div class="text-center">
            <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-1 text-xl font-bold">
                এখনি কিনুন

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
                </svg>
            </a>
        </div>
    </div>
    @endforeach
    @endif
</div>
{{-- <div class="owl-carousel_normal owl-theme">
    @foreach ($product->others_arr['videos'] as $video)
        <div class="item-video" data-merge="1"><a class="owl-video" href="https://www.youtube.com/watch?v={{$video['id']}}"></a></div>
    @endforeach
    @if($product_2)
        @foreach ($product_2->others_arr['videos'] as $video)
            <div class="item-video" data-merge="1"><a class="owl-video" href="https://www.youtube.com/watch?v={{$video['id']}}"></a></div>
        @endforeach
    @endif
</div> --}}

<div class="text-center">
    <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-3 text-xl font-bold">
        অর্ডার করতে চাই

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
        </svg>
    </a>
</div>
