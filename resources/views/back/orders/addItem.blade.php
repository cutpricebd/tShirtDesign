<tr>
    <td>
        {{$product->id}} <input type="hidden" name="products[]" value="{{$product->id ?? ''}}">

        <input type="hidden" name="tax_amount_input_hidden[]" class="tax_amount_input_hidden" value="{{$product->ProductData->calculated_tax_amount ?? 0}}">
    </td>
    <td>{{$product->title}}</td>
    <td>
        <img src="{{$product->img_paths['small']}}" style="width:35px">
    </td>
    <td>
        @if($product->type == 'Variable')
            <select name="product_data_id[]" class="form-control form-control-sm variation_select" required>
                <option value="" disabled selected>Selet Variation</option>
                @foreach ($product->VariableProductData as $product_data)
                    <option value="{{$product_data->id}}">{{$product_data->attribute_items_string}}</option>
                @endforeach
            </select>
            <input type="hidden" class="maximum_quantity" value="0">
        @else
            N/A
            <input type="hidden" name="product_data_id[]" value="{{$product->ProductData->id ?? ''}}">
            <input type="hidden" class="maximum_quantity" value="{{$product->ProductData->stock ?? 0}}">
        @endif
    </td>
    <td>
        <input type="number" name="price[]" value="{{$product->type == 'Simple' ? $product->ProductData->sale_price : 0}}" class="form-control form-control-sm price_input input_calc" style="width: 120px" readonly>
    </td>
    <td>
        <input type="number" name="quantity[]" class="form-control form-control-sm quantity_input" value="1" style="width: 120px" required>
    </td>
    <td>
        <input type="number" name="sub_total[]" value="{{$product->type == 'Simple' ? $product->ProductData->sale_price : 0}}" class="form-control form-control-sm sub_total" style="width: 120px" value="0" readonly>
    </td>
    <td class="text-right">
        <button class="btn btn-danger btn-sm remove_item" type="button"><i class="fas fa-trash"></i></button>
    </td>
</tr>
