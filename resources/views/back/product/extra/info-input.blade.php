@php
    $taxes = App\Models\Product\Tax::get();
@endphp

<div class="row">
    {{-- <div class="col-md-4">
        <div class="form-group">
            <label>Regular price</label>
            <input type="number" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}regular_price{{$type == 'variable' ? '[]' : ''}}" value="{{old('regular_price') ?? ($data->regular_price ?? '')}}" step="any">
        </div>
    </div> --}}
    @if(isset($data))
        <div class="col-md-4">
            <div class="form-group">
                <label>Previous Stock</label>
                <input type="number" class="form-control form-control-sm" name="abc" step="any" value="{{$data->stock}}" readonly>
            </div>
        </div>
    @endif

    <div class="col-md-4">
        <div class="form-group">
            <label>Add New Stock</label>
            <input type="number" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}add_new_stock{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{old('add_new_stock')}}">
        </div>
    </div>
     <div class="col-md-4">
        <div class="form-group">
            <label>Product Cost</label>
            <input type="number" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}product_cost{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{(old('product_cost') && $type != 'variable') ? old('product_cost') : ($data->cost ?? '')}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Regular Price</label>
            <input type="number" class="form-control form-control-sm regular_price" name="{{$name_prefix ?? ''}}regular_price{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{(old('regular_price') && $type != 'variable') ? (integer)old('regular_price') : ($data->regular_price ?? '')}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Sale Price*</label>
            <input type="number" class="form-control form-control-sm sale_price" name="{{$name_prefix ?? ''}}sale_price{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{(old('sale_price') && $type != 'variable') ? (integer)old('sale_price') : ($data->sale_price ?? '')}}" {{$type == 'simple' ? 'required' : ''}}>
        </div>
    </div>
    {{-- <div class="col-md-4">
        <div class="form-group">
            <label>Expire Date</label>
            <input type="date" class="form-control form-control-sm sale_price" name="{{$name_prefix ?? ''}}expire_date{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{(old('expire_date') && $type != 'variable') ? old('expire_date') : ($expire_date ?? '')}}">
        </div>
    </div> --}}
    {{-- <div class="col-md-4">
        <div class="form-group">
            <label>Product SKU*</label>
            <input type="text" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}sku_code{{$type == 'variable' ? '[]' : ''}}" value="{{(old('sku_code') && $type != 'variable') ? old('sku_code') : ($data->sku_code ?? '')}}" required>
        </div>
    </div> --}}
     <div class="col-md-3">
        <div class="form-group">
            <label>Shipping Weight(lbs)</label>
            <input type="number" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}shipping_weight{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{(old('shipping_weight') && $type != 'variable') ? old('shipping_weight') : ($data->shipping_weight ?? '')}}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Shipping Width(in)</label>
            <input type="number" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}shipping_width{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{(old('shipping_width') && $type != 'variable') ? old('shipping_width') : ($data->shipping_width ?? '')}}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Shipping Height(in)</label>
            <input type="number" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}shipping_height{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{(old('shipping_height') && $type != 'variable') ? old('shipping_height') : ($data->shipping_height ?? '')}}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Shipping Length(in)</label>
            <input type="number" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}shipping_length{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{(old('shipping_length') && $type != 'variable') ? old('shipping_length') : ($data->shipping_length ?? '')}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Rack Number</label>
            <input type="number" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}rack_number{{$type == 'variable' ? '[]' : ''}}" value="{{(old('rack_number') && $type != 'variable') ? old('rack_number') : ($data->rack_number ?? '')}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Product Unit*</label>
            <select name="{{$name_prefix ?? ''}}unit{{$type == 'variable' ? '[]' : ''}}" class="form-control form-control-sm unit" {{$type == 'simple' ? 'required' : ''}}>
                {{-- <option value="">Select Unit</option> --}}
                <option value="Pcs" {{($data->unit ?? '') == 'Pcs' ? 'selected' : ''}}>Pcs</option>
                <option value="G" {{($data->unit ?? '') == 'G' ? 'selected' : ''}}>G</option>
                <option value="KG" {{($data->unit ?? '') == 'KG' ? 'selected' : ''}}>KG</option>
                <option value="ML" {{($data->unit ?? '') == 'ML' ? 'selected' : ''}}>ML</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Unit Amount*</label>
            <input type="number" class="form-control form-control-sm unit_amount" step="any" name="{{$name_prefix ?? ''}}unit_amount{{$type == 'variable' ? '[]' : ''}}" value="{{(old('unit_amount') && $type != 'variable') ? (integer)old('unit_amount') : ($data->unit_amount ?? 1)}}" {{$type == 'simple' ? 'required' : ''}}>
        </div>
    </div>

    {{-- @if($type == 'variable')
        <div class="col-md-4">
            @isset ($data)
                <div class="text-left">
                    <img src="{{$data->img_paths['small']}}" style="width: 70px">
                </div>
            @endisset

            <div class="form-group">
                <label>Image</label>
                <div class="custom-file text-left">
                    @isset($name_prefix)
                    <input type="file" class="custom-file-input" name="{{$name_prefix ? ($name_prefix . $data->id) : ''}}variation_image">
                    @else
                    <input type="file" class="custom-file-input" name="variation_image[]">
                    @endisset

                    <label class="custom-file-label">Choose file...</label>
                </div>
            </div>
        </div>
    @endif --}}

    {{-- <div class="col-12">
        <hr>
    </div> --}}

     <div class="col-md-4">
        <div class="form-group">
            <label>Promotion Price</label>
            <input type="number" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}promotion_price{{$type == 'variable' ? '[]' : ''}}" step="any" value="{{(old('promotion_price') && $type != 'variable') ? old('promotion_price') : ($data->promotion_price ?? '')}}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Start Date</label>
            <input type="date" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}promotion_start_date{{$type == 'variable' ? '[]' : ''}}" value="{{(old('promotion_start_date') && $type != 'variable') ? old('promotion_start_date') : ((isset($data) && $data->promotion_start_date) ? date('Y-m-d', strtotime($data->promotion_start_date)) : '')}}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>End Date</label>
            <input type="date" class="form-control form-control-sm" name="{{$name_prefix ?? ''}}promotion_end_date{{$type == 'variable' ? '[]' : ''}}" value="{{(old('promotion_end_date') && $type != 'variable') ? old('promotion_end_date') : ((isset($data) && $data->promotion_end_date) ? date('Y-m-d', strtotime($data->promotion_end_date)) : '')}}">
        </div>
    </div>

    <div class="col-12">
        <hr>
    </div>

     <div class="col-md-6">
        <div class="form-group">
            <label>Product TAX*</label>
            <select name="{{$name_prefix ?? ''}}tax_id{{$type == 'variable' ? '[]' : ''}}" class="form-control form-control-sm tax" {{$type == 'simple' ? 'required' : ''}} required>
                @if(!count($taxes))
                    <option value="">Select TAX</option>
                @endif
                @foreach ($taxes as $tax)
                    <option value="{{$tax->id}}" {{(($data->tax_id ?? '') == $tax->id) ? 'selected' : ''}}>{{$tax->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Tax Method</label>
            <select name="{{$name_prefix ?? ''}}tax_method{{$type == 'variable' ? '[]' : ''}}" class="form-control form-control-sm tax_method" {{$type == 'simple' ? 'required' : ''}} required>
                <option value="Exclusive" {{($data->tax_method ?? '') == 'Exclusive' ? 'selected' : ''}}>Exclusive</option>
                <option value="Inclusive" {{($data->tax_method ?? '') == 'Inclusive' ? 'selected' : ''}}>Inclusive</option>
            </select>
        </div>
    </div>
</div>
