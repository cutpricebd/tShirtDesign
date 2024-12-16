<div class="owl-carousel_normal owl-carousel owl-theme mb-5">
    @foreach ($product->product_images as $image)
        <img src="{{$image->paths['original']}}" style="height: 80vh;object-fit:contain" class="w-full bg-gray-100" alt="{{$product->name}}">
    @endforeach
</div>
