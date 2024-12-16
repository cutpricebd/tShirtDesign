<div class="modal-body detailsModalBody">
    <div class="row">
        <div class="col-md-5">
            <img src="{{$product->img_paths['medium']}}" class="whp">
        </div>

        <div class="col-md-7">
            <table class="table table-sm table-striped">
                <tr>
                    <td class="text-right">Type</td>
                    <th>{{$product->type}}</th>
                </tr>
                <tr>
                    <td class="text-right">Title</td>
                    <th>{{$product->title}}</th>
                </tr>
                <tr>
                    <td class="text-right">SKU Code</td>
                    <th>{{$product->ProductData->sku_code ?? ''}}</th>
                </tr>
                <tr>
                    <td class="text-right">Brand</td>
                    <th>{{$product->Brand->title ?? ''}}</th>
                </tr>
                <tr>
                    <td class="text-right">Categories</td>
                    <th>
                    @foreach ($product->Categories as $category)
                        {{$category->title}},
                    @endforeach
                    </th>
                </tr>
                <tr>
                    <td class="text-right">Product Cost</td>
                    <th>{{$product->ProductData->cost ?? ''}}</th>
                </tr>
                <tr>
                    <td class="text-right">Sale Price</td>
                    <th>{{$product->ProductData->sale_price ?? ''}}</th>
                </tr>
                <tr>
                    <td class="text-right">Offer Price</td>
                    <th>{{$product->ProductData->regular_price ?? ''}}</th>
                </tr>
                <tr>
                    <td class="text-right">Available Stock</td>
                    <th>{{$product->stock}}</th>
                </tr>
                <tr>
                    <td class="text-right">Product HST</td>
                    <th>{{($product->tax_type == 'Fixed' ? ($settings_g['currency_symbol'] ?? '$') : '') . $product->tax_amount . ($product->tax_type == 'Percentage' ? '%' : '')}}</th>
                </tr>
                <tr>
                    <td class="text-right">HST Method</td>
                    <th>{{$product->tax_method}}</th>
                </tr>
            </table>
        </div>
    </div>
</div>

{{-- <div class="modal-footer">
    <form class="d-inline-block" action="{{route('back.products.destroy', $product->id)}}" method="POST">
        @method('DELETE')
        @csrf

        <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you like to delete this item permanently?')"><i class="fas fa-trash"></i> Delete</button>
    </form>
    <a href="{{route('back.products.edit', $product->id)}}" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div> --}}
