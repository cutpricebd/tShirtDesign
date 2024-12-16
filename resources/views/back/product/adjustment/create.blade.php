@extends('back.layouts.master')
@section('title', 'Add new Adjustment')

@section('head')
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('master')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h6 class="d-inline-block">Seatch Product</h6>

                {{-- <select name="category" class="form-control form-control-sm d-inline-block float-right select_category" style="width: 140px;">
                    <option value="All">Select category</option>

                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                </select> --}}
            </div>

            <div class="card-body">
                <div class="form-group">
                    <select class="form-control selectpicker_products"></select>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{route('back.adjustments.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card border-light mt-3 shadow">
        <div class="card-header">
            <h6 class="d-inline-block">Listed Product</h6>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Variation</th>
                    <th scope="col">Type</th>
                    <th scope="col" style="width: 120px">Unit Cost</th>
                    <th scope="col" style="width: 120px">Quantity</th>
                    <th scope="col" style="width: 120px">Subtotal</th>
                    <th scope="col" class="text-right"><i class="fas fa-trash"></i></th>
                </tr>
                </thead>
                <tbody class="listed_items">
                    @if($product)
                        @include('back.product.adjustment.addItem', [
                            'product' => $product
                        ])
                    @endif
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Grand Total*</label>
                        <input type="number" name="grand_total" value="{{$product->ProductData->cost ?? '0'}}" class="form-control form-control-sm grand_total" readonly>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="form-group">
                        <label>Note*</label>
                        <input type="text" name="note" class="form-control form-control-sm" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success">Submit</button>
            <br>
            <small><b>NB: *</b> marked are required field.</small>
        </div>
    </div>
</form>
@endsection

@section('footer')
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    // Select2
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
    // $(document).ready(function () {
    //     fill_datatable();

    //     function fill_datatable(){
    //         let category = $('.select_category').val();

    //         let dataTable = $('#dataTable').DataTable({
    //             "processing": true,
    //             "serverSide": true,
    //             "ajax": {
    //                 "url": "{{route('back.stocks.productTable')}}",
    //                 "dataType": "json",
    //                 "type": "POST",
    //                 "data": {_token: "{{csrf_token()}}", category}
    //             },
    //             "columns": [
    //                 {"data": "id"},
    //                 {"data": "name"},
    //                 {"data": "image"},
    //                 {"data": "type"},
    //                 {"data": "action"}
    //             ],
    //             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    //             "order": [[0, "desc"]],
    //             "columnDefs": [
    //                 { orderable: true, className: 'reorder', targets: [0] },
    //                 { orderable: false, targets: '_all' }
    //             ]
    //         });
    //     }

    //     // Filter Product
    //     $(document).on('change', '.select_category', function(){
    //         $('#dataTable').DataTable().destroy();
    //         fill_datatable();
    //     });
    // });

    $(document).on('change', '.selectpicker_products',  function(){
        let id = $(this).val();
        cLoader();

        $.ajax({
            url: '{{route("back.adjustments.addItem")}}',
            method: 'POST',
            data: {id, _token: '{{csrf_token()}}'},
            success: function(result){
                cLoader('h');

                $('.listed_items').append(result);

                grandCalculation();
            },
            error: function(){
                cLoader('h');
            }
        });
    });


    // Add Item
    $(document).on('click', '.add_item', function(){
        let id = $(this).data('id');
        cLoader();

        $.ajax({
            url: '{{route("back.adjustments.addItem")}}',
            method: 'POST',
            data: {id, _token: '{{csrf_token()}}'},
            success: function(result){
                cLoader('h');

                $('.listed_items').append(result);

                grandCalculation();
            },
            error: function(){
                cLoader('h');
            }
        });
    });

    // Change Varioation
    $(document).on('change', '.change_variation', function(){
        let variation_id = $(this).val();
        cLoader();

        $.ajax({
            url: '{{route("back.adjustments.getCost")}}',
            method: 'POST',
            data: {variation_id, _token: '{{csrf_token()}}'},
            context: this,
            success: function(cost){
                cLoader('h');
                $(this).closest('tr').find('.price_input').val(cost);
            },
            error: function(){
                cLoader('h');
            }
        });
    });

    // Edit input
    $(document).on('change keyup', '.input_calc', function(){
        // let with_tax = 0;
        // // let discount_amount = 0;
        // let with_discount = 0;

        // let tax = $(this).closest('tr').find('.tax_input').val();
        // if(tax == ''){
        //     tax = 0;
        // }
        // let discount = $(this).closest('tr').find('.discount_input').val();
        // if(discount == ''){
        //     discount = 0;
        // }
        let price = $(this).closest('tr').find('.price_input').val();
        if(price == ''){
            price = 0;
        }
        let quantity = $(this).closest('tr').find('.quantity_input').val();
        if(quantity == ''){
            quantity = 0;
        }
        let type = $(this).closest('tr').find('.type_input').val();

        // Generate Discount
        // let input_discount_amount = discount.replace('%', '');
        // with_discount = parseInt(price * quantity) - ((price * discount) / 100);
        // if(discount.includes('%')){
        // }else{
        //     with_discount = parseInt(price) - parseInt(discount);
        // }

        // // Generate Tax
        // tax = tax.replace('%', '');
        // tax = ((price * quantity) * tax) / 100;
        // if(tax.includes('%')){
        // }

        if(type == 'Addition'){
            $(this).closest('tr').find('.sub_total').val(parseInt(price) * parseInt(quantity));
        }else{
            $(this).closest('tr').find('.sub_total').val(0);
        }
        // console.log(discount);

        grandCalculation();
    });

    // Remove Item
    $(document).on('click', '.remove_item', function(){
        if(confirm('Are you sure to remobe?')){
            $(this).closest('tr').remove();

            grandCalculation();
        }
    });

    // Calculation
    // function subTotalCalculation(tax = 0, discount = 0, cost, quantity){
    //     // let sub_totals = $('.sub_total').map(function () {
    //     //     if($(this).val() == ''){
    //     //         return 0;
    //     //     }else{
    //     //         return $(this).val();
    //     //     }
    //     // });

    //     // var grand_total = sub_totals.get().reduce(function(a, b){
    //     //     return a + b;
    //     // }, 0);

    //     return 100;
    // }
    function grandCalculation(){
        let sub_totals = $('.sub_total').map(function () {
            if($(this).val() == ''){
                return 0;
            }else{
                return $(this).val();
            }
        });

        var grand_total = sub_totals.get().reduce(function(a, b){
            return parseInt(a) + parseInt(b);
        }, 0);

        // console.log(grand_total);

        $('.grand_total').val(grand_total);
    }
</script>
@endsection
