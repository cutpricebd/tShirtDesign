@extends('back.layouts.master')
@section('title', 'Upload to Google Merchant')

@section('head')
    <!-- DataTable -->
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <!-- Select 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!-- End Select 2 -->

    <style>
        #jumpPageDaraz {
            position: absolute;
            bottom: 15px;
            width: 86px;
            left: 300px;
        }
        .error_logs{text-align: left;
        border: 6px solid;
        padding: 8px 29px;
        margin-bottom: 20px;}
        .error_logs ul{max-height: 350px;overflow: auto;display: flex;flex-direction:column-reverse;}
        div.dropdown-menu{max-width: 650px !important;}
    </style>
@endsection

@section('main-content')
    <div class="card mb-4 shadow">
        <div class="card-header text-info">
            <h5 class="d-inline-block font-weight-bold d-inline-block"><i class="fas fa-fw fa-table"></i> All Products</h5>

            <a target="_blank" href="https://developers.google.com/shopping-content/guides/quickstart" class="btn btn-info btn-sm float-right">Get Credentials</a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <select class="form-control selectpicker selectCategory mb-4" data-live-search="true">
                        <option value="All">Select Category</option>
                        @foreach($product_categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @if(count($category->subCategory) > 0)
                                @foreach($category->subCategory as $subCat)
                                    <option value="{{$subCat->id}}">---{{$subCat->name}}</option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="productDataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="bg-info text-light" role="row">
                        <th><button class="btn btn-success btn-sm addItem" data-id="all">Add all Item</button></th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price ({{ Helper::Web('General Settings', 'currency') }})</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <input type="number" class="form-control" id="jumpPageDaraz">
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header text-info sd_area">
            <h5 class="d-inline-block font-weight-bold"><i class="fas fa-fw fa-table"></i> Items for Google Merchant upload</h5>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered itemsTable" >
                <thead>
                <tr class="bg-info text-light" role="row">
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Type</th>
                    {{-- <th>Category</th> --}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="selectedItem">

                </tbody>
                <tfoot>
                <tr>
                    <th colspan="8">
                        <div class="row">
                            <div class="col-md-3">
                                <select class="selectpicker form-control google_category" data-live-search="true">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->category_id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-9">
                                <div class="sd_area">
                                    <button class="btn btn-info uploadSubmit">Uploads to Google Merchant</button>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
            <div class="response_Status text-center" style="display: none">
                <div class="error_logs">
                    <b class="text-danger">Error Logs--</b>
                    <ul></ul>
                </div>

                <i class="fas fa-cog fa-spin loader_icon" style="font-size:38px;"></i>
                <br>
                <br>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated ajaxProgress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>

                <b>Total: <span class="total_count">0</span> | </b>
                <b>Success: <span class="success_count">0</span> | </b>
                <b>Error: <span class="error_count">0</span></b>
                <p class="font-italic text-danger"><b>NB:</b> Don't close this tab before complete.</p>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <!-- Select 2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            // Select2
            $('.selectpicker').selectpicker();

            fill_datatable();

            function fill_datatable(category_id = ''){
                // Products Data Tables Ajax
                let Dtable = $('#productDataTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{route('gm.products.table')}}",
                        "dataType": "json",
                        "type": "post",
                        "data": {_token: "{{csrf_token()}}", category_id}
                    },
                    "columns": [
                        {"data": "add_item"},
                        {"data": "image"},
                        {"data": "name"},
                        {"data": "price"},
                        {"data": "type"},
                        {"data": "action"}
                    ],
                    "order": [[0, "desc"]],
                    "columnDefs": [
                        {orderable: false, targets: [0]},
                        {orderable: false, targets: '_all'},
                    ]
                });

                // Datatable Page Jump
                $('#jumpPageDaraz').on('input change paste keyup', function () {
                    let page = $('#jumpPageDaraz').val();
                    if (page === '') {
                        page = 0
                    }
                    page = parseFloat(page) - 1;
                    if (page <= 0) {
                        page = 0
                    }
                    Dtable.page(page).draw(false);
                });
            }

            // Prduct category filter
            $(document).on('change', '.selectCategory', function(){
                let c_id = $(this).val();
                if(c_id != ''){
                    $('#productDataTable').DataTable().destroy();
                    fill_datatable(c_id);
                }
            });
        });


        // Add item for GM upload
        $(document).on('click', '.addItem', function () {
            let status = true;
            let id = $(this).data('id');
            let request_id = '';
            let cid;

            // Existing ID
            let ids = $('.selectedID').map(function () {
                return $(this).html();
            });

            if (id === "all"){
                let allIDs = $('.addItemID').map(function () {
                    return $(this).val();
                });

                // Check Duplicate
                $.each(allIDs, function (index, aID) {
                    cid = true;
                    $.each(ids, function (ind, item) {
                        if (aID == item) {
                            cid = false;
                        }
                    });

                    if(cid){
                        request_id += aID + ',';
                    }
                });
            } else{
                // Check Duplicate
                $.each(ids, function (index, item) {
                    if (item == id) {
                        status = false;
                    }
                });

                if(status){
                    request_id += id + ',';
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'Item already added'
                    });
                    return false;
                }
            }

            // Ajax Action
            $('.loader').show();
            $.ajax({
                url: '{{ route("gm.get.product") }}',
                method: 'post',
                data: {
                    request_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (result) {
                    $('.loader').hide();
                    $('.selectedItem').append(result);
                },
                error: function () {
                    $('.loader').hide();
                    Toast.fire({
                        icon: 'error',
                        title: 'Something wrong'
                    });
                }
            });
        });

        // Remove selected item
        $(document).on('click', '.removeSelected', function () {
            if (confirm('Are you sure to remove?')){
                $(this).closest('tr').remove();
                Toast.fire({
                    icon: 'success',
                    title: 'Items removed successfully'
                });
            }
        });

        let upload_time;

        // Upload Submit
        $(document).ready(function () {
            $(document).on('click', '.uploadSubmit', function () {
                let product_id;
                let category_id;
                let out_arr;
                let items = $('.selectedID').map(function () {
                    product_id = $(this).data('product');

                    return product_id
                });
                // let categories = $('.google_categort').map(function () {
                //     category_id = $(this).val();

                //     return category_id
                // });

                // Ajax Action
                if(items.length > 0){
                    $('.itemsTable').hide();
                    $('.response_Status').show();
                    $('.total_count').html(items.length);

                    let output = '<div class="finalItemsContainer" style="display: none">';
                    $.each(items, function (ind, item) {
                        // out_arr = item.split(',');
                        output += '<input value="'+ item +'" class="finalItems" type="hidden">';
                    });
                    output += '</div>';
                    // output += '<div class="finalItemsContainer2" style="display: none">';
                    //     $.each(categories, function (ind, category) {
                    //     output += '<input value="'+ category +'" class="finalCategory" type="hidden">';
                    // });
                    // output += '</div>';

                    // Output
                    $('.response_Status').append(output);
                    // console.log(output);
                    // return false;

                    uploadingItems();
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'Please add some product.'
                    });
                }
            });

            function uploadingItems() {
                let product_id = $('.finalItems:first-child').val();
                // $('.finalCategory:first-child').remove();
                let product_category = $('.google_category').val();
                // let product_category = $('.finalCategory:first-child').val();
                let items = $('.finalItems').map(function () {
                    return $(this).val();
                });
                // $('.' + product_id).remove();
                $('.finalItems:first-child').remove();
                // $('.finalCategory:first-child').remove();
                // alert(product_category);

                if (items.length > 0){
                    $.ajax({
                        url: '{{ route("gm.upload") }}',
                        method: 'post',
                        data: {
                            product_id: product_id,
                            product_category: product_category,
                            // items: items.get(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (result) {
                            let success = $('.success_count').html();
                            let error = $('.error_count').html();

                            upload_time = setTimeout(function () {
                                uploadingItems();
                            }, 10000);
                            if (result == 'success') {
                                $('.success_count').html(parseInt(success) + parseInt(1));
                            }else{
                                $('.error_count').html(parseInt(error) + parseInt(1));
                                $('.error_logs ul').prepend(result);
                            }

                            // console.log(result);

                            ajaxProgress();
                        },
                        error: function () {
                            let error = $('.error_count').html();
                            $('.error_count').html(parseInt(error) + parseInt(1));
                            // $('.error_logs ul').prepend(result);

                            upload_time = setTimeout(function () {
                                uploadingItems();
                            }, 10000);

                            ajaxProgress();
                        }
                    });
                }else{
                    // location.reload();
                    $('.loader_icon').removeClass('fa-spin');
                    $('.loader_icon').removeClass('fa-cog');
                    $('.loader_icon').addClass('fa-check');
                }
            }

            function ajaxProgress(){
                let p_total_count = $('.total_count').html();
                let p_success = $('.success_count').html();
                let p_error = $('.error_count').html();
                let p_done = parseInt(p_success) + parseInt(p_error);
                let p_percentage;

                if(p_done == p_total_count){
                    $('.ajaxProgress').attr('style', 'width:100%');
                    $('.ajaxProgress').attr('aria-valuenow', "100");
                    $('.ajaxProgress').removeClass('progress-bar-animated');
                    $('.ajaxProgress').addClass('bg-success');
                }else{
                    if(p_done == 0){
                        p_percentage = 0;
                    }else{
                        p_percentage = Math.round((p_done / p_total_count) * 100);
                    }

                    $('.ajaxProgress').attr('style', ('width:'+p_percentage+'%'));
                    $('.ajaxProgress').attr('aria-valuenow', p_percentage);
                }
            }
        });
    </script>
@endsection
