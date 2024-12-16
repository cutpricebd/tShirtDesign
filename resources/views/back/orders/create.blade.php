@extends('back.layouts.master')
@section('title', 'Create Order')

@section('head')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('master')
<form action="{{route('back.orders.store')}}" method="POST" enctype="multipart/form-data">
@csrf

<div class="card border-light mt-3 shadow">
    <div class="card-body">
        <div class="row">
            {{-- <div class="col-md-4">
                <div class="form-group">
                    <label>Date*</label>
                    <input type="date" class="form-control form-control-sm" name="date" required>
                </div>
            </div> --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label><b>Reference No</b></label>
                    <input type="text" class="form-control form-control-sm" name="reference_no">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="d-block"><b>Select Customer*</b> <a target="_blank" href="{{route('back.customers.create')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i></a></label>
                    <select name="customer" class="form-control form-control-sm selectpicker" required>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="d-block"><b>Select Product</b> <a target="_blank" href="{{route('back.products.create')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i></a></label>
                    <select class="form-control form-control-sm selectpicker_products"></select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h6 class="mb-0">Listed Products</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Variation</th>
                            {{-- <th scope="col">Tax %</th>
                            <th scope="col">Discount %</th> --}}
                            <th scope="col" style="width: 120px">Unit Price</th>
                            <th scope="col" style="width: 120px">Quantity</th>
                            <th scope="col" style="width: 120px">Subtotal</th>
                            <th scope="col" class="text-right"><i class="fas fa-trash"></i></th>
                        </tr>
                        </thead>
                        <tbody class="listed_items">
                        </tbody>
                    </table>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Order Status*</b></label>

                            <select name="status" class="form-control form-control-sm" required>
                                <option value="Processing">Processing</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Payment Status*</b></label>

                            <select name="payment_status" class="form-control form-control-sm" required>
                                {{-- <option value="Pending">Pending</option> --}}
                                <option value="Due">Due</option>
                                {{-- <option value="Partial">Partial</option> --}}
                                <option value="Paid">Paid</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Payment Method</b></label>

                            <select name="payment_method" class="form-control form-control-sm" required>
                                <option value="Visa/Master">Visa/Master</option>
                                <option value="PayPal">PayPal</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Attachments</b></label>

                            <input type="file" name="attachment" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Order Note</b></label>
                            <textarea name="note" class="form-control form-control-sm" cols="30" rows="5"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Staff Note</b></label>
                            <textarea name="staff_note" class="form-control form-control-sm" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h6 class="mb-0">Summary</h6>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Subtotal:</th>
                        <td>
                            {{$settings_g['currency_symbol']}}<span class="product_sub_total">0</span>
                            <input type="hidden" name="product_total" class="product_total_input" value="0">
                        </td>
                    </tr>
                    <tr>
                        <th>Discount*:</th>
                        <td style="width: 150px">
                            <input type="text" class="form-control form-control-sm summary_input discount_input" name="discount" value="0" required>
                        </td>
                    </tr>
                    <tr>
                        <th>After Discount:</th>
                        <td>
                            {{$settings_g['currency_symbol']}}<span class="after_discount">0</span>
                            <input type="hidden" name="discount_amount" value="0" class="discount_amount">
                        </td>
                    </tr>
                    <tr>
                        <th>Tax:</th>
                        <td>
                            {{$settings_g['currency_symbol']}}<span class="tax_amount">0</span>
                            <input type="hidden" name="tax_amount" class="tax_amount_input" value="0">
                        </td>
                    </tr>
                    <tr>
                        <th>Shipping*:</th>
                        <td style="width: 150px">
                            <input type="text" class="form-control form-control-sm summary_input shipping_input" name="shipping" value="{{$settings_g['shipping_charge'] ?? 0}}" required>
                        </td>
                    </tr>
                    <tr>
                        <th>Grand Total:</th>
                        <td>
                            {{$settings_g['currency_symbol']}}<span class="grand_total">{{$settings_g['shipping_charge'] ?? 0}}</span>
                            <input type="hidden" name="grand_total" class="grand_total_input" value="0">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card-footer">
                <button class="btn btn-success btn-block">Submit</button>
                <br>
                <small><b>NB: *</b> marked are required field.</small>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@section('footer')
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        // Select2
        $('.selectpicker').select2({
            placeholder: "Search Customer",
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("back.customers.selectList") }}?type=customer',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        $('.selectpicker_products').select2({
            placeholder: "Search Product",
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("back.products.selectList") }}',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $(document).on('change', '.selectpicker_products',  function(){
            let product_id = $(this).val();
            cLoader();

            $.ajax({
                url: '{{route("back.orders.addItem")}}',
                method: 'POST',
                data: {product_id, _token: '{{csrf_token()}}'},
                success: function(result){
                    cLoader('h');

                    if(result == 'false'){
                        cAlert('error', 'Out of stock!');
                    }else{
                        $('.listed_items').append(result);
                        grandCalculation();
                    }
                },
                error: function(){
                    cLoader('h');
                }
            });
        });

        // Remove Item
        $(document).on('click', '.remove_item', function(){
            if(confirm('Are you sure to remobe?')){
                $(this).closest('tr').remove();

                grandCalculation();
            }
        });

        // Edit input
        $(document).on('change keyup', '.quantity_input', function(){
            let maximum_quantity = $(this).closest('tr').find('.maximum_quantity').val();
            let quantity = $(this).closest('tr').find('.quantity_input').val();
            if(quantity > maximum_quantity){
                quantity = maximum_quantity;
                $(this).closest('tr').find('.quantity_input').val(maximum_quantity);

                cAlert('error', ('Maximum quantity ' + maximum_quantity));
            }

            let price = $(this).closest('tr').find('.price_input').val();
            if(price == ''){
                price = 0;
            }
            if(quantity == ''){
                quantity = 0;
            }

            $(this).closest('tr').find('.sub_total').val(parseInt(price) * parseInt(quantity));


            grandCalculation();
        });

        $(document).on('change keyup', '.input_calc', function(){
            let price = $(this).closest('tr').find('.price_input').val();
            if(price == ''){
                price = 0;
            }
            let quantity = $(this).closest('tr').find('.quantity_input').val();
            if(quantity == ''){
                quantity = 0;
            }

            $(this).closest('tr').find('.sub_total').val(parseInt(price) * parseInt(quantity));

            grandCalculation();
        });

        $(document).on('change keyup', '.summary_input', function(){
            grandCalculation();
        });

        // Variation select
        $(document).on('change', '.variation_select', function(){
            let product_data_id = $(this).val();
            // $(this).closest('tr').find('.quantity_input').val(1);
            // let product_quantity = $(this).closest('tr').find('.quantity_input').val();
            // let product_quantity = 1;

            $.ajax({
                url: '{{route("back.products.productDataJson")}}',
                method: 'POST',
                context: this,
                dataType: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    product_data_id
                },
                success: function(result){
                    if(result.code == 200){
                        $(this).closest('tr').find('.price_input').val(result.data.sale_price);
                        $(this).closest('tr').find('.sub_total').val(result.data.sale_price * 1);
                        $(this).closest('tr').find('.quantity_input').val(1);
                        $(this).closest('tr').find('.quantity_input').removeAttr('readonly', '');
                        $(this).closest('tr').find('.maximum_quantity').val(result.data.stock);
                    }else{
                        cAlert('error', 'Out of Stock!');
                        $(this).closest('tr').find('.sub_total').val(result.data.sale_price * 0);
                        $(this).closest('tr').find('.quantity_input').val(0);
                        $(this).closest('tr').find('.quantity_input').attr('readonly', '');
                        $(this).closest('tr').find('.maximum_quantity').val(0);
                    }

                    grandCalculation();
                },
                error: function(){
                    console.log('Something wrong!');
                    grandCalculation();
                }
            });
        });

        function grandCalculation(){
            let after_discount = 0;

            let sub_totals = $('.sub_total').map(function () {
                if($(this).val() == ''){
                    return 0;
                }else{
                    return $(this).val();
                }
            });

            var product_total = sub_totals.get().reduce(function(a, b){
                return parseInt(a) + parseInt(b);
            }, 0);
            $('.product_sub_total').html(product_total);
            $('.product_total_input').val(product_total);

            // Tax Calculation
            let tax_totals = $('.tax_amount_input_hidden').map(function () {
                if($(this).val() == ''){
                    return 0;
                }else{
                    return $(this).val() * ($(this).closest('tr').find('.quantity_input').val() ?? 1);
                }
            });
            var tax_amount = tax_totals.get().reduce(function(a, b){
                return parseInt(a) + parseInt(b);
            }, 0);
            $('.tax_amount').html(tax_amount);
            $('.tax_amount_input').val(tax_amount);

            let discount = $('.discount_input').val();
            if(discount == ''){
                discount = 0;
            }

            let shipping = $('.shipping_input').val();
            if(shipping == ''){
                shipping = 0;
            }

            if(discount > 0){
                after_discount = product_total - ((product_total * discount) / 100);
                $('.discount_amount').val((product_total * discount) / 100);
            }else{
                $('.discount_amount').val(0);
                after_discount = product_total;
            }
            $('.after_discount').html(after_discount);

            let tax = '{{$settings_g["tax"] ?? 0}}';
            let tax_type = '{{$settings_g["tax_type"] ?? ''}}';
            // let tax_amount = 0;
            // if(tax){
            //     if(tax_type == 'Fixed'){
            //         $('.tax_amount').html(tax);
            //         $('.tax_amount_input').val(tax);
            //         tax_amount = tax;
            //     }else{
            //         $('.tax_amount').html((after_discount * tax) / 100);
            //         $('.tax_amount_input').val((after_discount * tax) / 100);
            //         tax_amount = (after_discount * tax) / 100;
            //     }
            // }

            // console.log(grand_total);
            $('.grand_total').html(parseInt(after_discount) + parseInt(tax_amount) + parseInt(shipping));
            $('.grand_total_input').html(parseInt(after_discount) + parseInt(tax_amount) + parseInt(shipping));
        }
    </script>
@endsection
