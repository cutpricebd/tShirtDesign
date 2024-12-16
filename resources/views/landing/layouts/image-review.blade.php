@if(count($image_reviews))
<div class="text-center">
    <a href="#" data-scroll-nav="2" class="mt-8 mb-4 inline-block bg-green-800 text-white rounded px-4 py-3 text-xl font-bold">
        অর্ডার করতে চাই

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block animate-bounce">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5"></path>
        </svg>
    </a>
</div>

<h2 class="text-xl md:text-4xl bg-yellow-300 text-center py-2 font-bold px-1 rounded mb-4">কাস্টমারের রিভিউ দেখুন:</h2>

<div class="owl-carousel_normal owl-carousel owl-theme mb-4">
    @foreach ($image_reviews as $image_review)
        <a href="{{$image_review->img_path}}" target="_blank" class="block">
            <img src="{{$image_review->img_path}}" style="height: 80vh;object-fit:contain" class="w-full bg-gray-100" alt="{{$product->name}}">
        </a>
    @endforeach
</div>
@endif
