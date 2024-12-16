@extends('back.layouts.master')
@section('title', 'Create Landing Builders')

@section('head')
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('master')
    <form action="{{route('back.landingBuilders.store')}}" method="POST">
        @csrf

        <div class="card shadow mb-3">
            <div class="card-header">
                <h5 class="m-0 d-inline-block mt-1"><b>Create Landing Builders</b></h5>

                <a href="{{route('back.landingBuilders.index')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-angle-left"></i> Back</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label><b>Page Title</b>*</label>
                            <input type="text" name="title" class="form-control" value="{{old('title')}}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Theme</b>*</label>
                            <select name="theme" class="form-control" name="theme" required>
                                <option value="default">Default</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label><b>Head Code</b></label>
                            <textarea name="head_code" class="form-control" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label><b>Body Code</b></label>
                            <textarea name="body_code" class="form-control" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label><b>Footer Code</b></label>
                            <textarea name="footer_code" class="form-control" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label><b>Server Site Track</b></label>
                            <select name="server_site_track" class="form-control">
                                <option value="No" checked>No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>Pixel ID</b></label>

                            <input name="pixel_id" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><b>Pixel Access Token</b></label>

                            <input name="pixel_access_token" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group position-relative">
                    <label><b>Search Product</b></label>
                    <select class="form-control form-control-sm selectpicker_products" name="product"></select>
                </div>
            </div>
        </div>

        <div class="card shadow text-dark mb-3">
            <div class="card-header"><h5><b>Products</b></h5></div>

            <div class="card-body">
                <table id="stock_addList" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="allStockProduct">
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info">Create</button>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
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
    </script>

    <script>
        // Add Product to Stick
        $(document).on('change', '.selectpicker_products', function () {
            let id = $(this).val();

            $('.loader').show();
            // Ajax Data
            $.ajax({
                url: '{{route("back.landingBuilders.addProduct")}}',
                method: 'GET',
                data: {id, _token: '{{csrf_token()}}'},
                success: function (result) {
                    $('.loader').hide();
                    $('#allStockProduct').append(result);
                }
            });
        });

        // Delete Product
        $(document).on('click', '.removeProduct', function () {
            if (confirm("Are you sure to delete?")) {
                $(this).closest('tr').remove();
            }
        });
    </script>
@endsection
