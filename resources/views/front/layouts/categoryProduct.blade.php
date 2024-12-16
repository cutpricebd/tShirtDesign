<div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 px-4">
    @foreach ($products as $product)
        @if($product)
            @include('front.layouts.product-loop2', [
                'product' => $product
            ])
        @endif
    @endforeach
    <div class="my-6 mb-8">
        {{$products->links('pagination::tailwind')}}
    </div>
</div>