@extends('back.layouts.master')
@section('title', 'Edit Landing Builders')

@section('head')
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('master')
    <form action="{{route('back.landingBuilders.update', $landing->id)}}" method="POST">
        @csrf

        <div class="card shadow mb-3">
            <div class="card-header">
                <h5 class="m-0 d-inline-block mt-1"><b>Edit Landing Builders</b></h5>

                <a href="{{route('back.landingBuilders.index')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-angle-left"></i> Back</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label><b>Page Title</b>*</label>
                            <input type="text" name="title" class="form-control" value="{{old('title', $landing->title)}}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Theme</b>*</label>
                            <select name="theme" class="form-control" name="theme" required>
                                <option value="default" @selected($landing->theme == 'default')>Default</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label><b>Head Code</b></label>
                            <textarea name="head_code" class="form-control" cols="30" rows="10">{{$landing->head_code}}</textarea>
                        </div>

                        <div class="form-group">
                            <label><b>Body Code</b></label>
                            <textarea name="body_code" class="form-control" cols="30" rows="10">{{$landing->body_code}}</textarea>
                        </div>

                        <div class="form-group">
                            <label><b>Footer Code</b></label>
                            <textarea name="footer_code" class="form-control" cols="30" rows="10">{{$landing->footer_code}}</textarea>
                        </div>

                        <div class="form-group">
                            <label><b>Server Site Track</b></label>
                            <select name="server_site_track" class="form-control">
                                <option value="No" {{($landing->server_track ?? 'No' == 'No') ? 'selected' : ''}}>No</option>
                                <option value="Yes" {{($landing->server_track ?? 'No' == 'Yes') ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>Pixel ID</b></label>

                            <input name="pixel_id" class="form-control" value="{{$landing->pixel_id}}">
                        </div>
                        <div class="form-group">
                            <label><b>Pixel Access Token</b></label>

                            <input name="pixel_access_token" class="form-control" value="{{$landing->pixel_access_token}}">
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
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <img style="max-height: 80px;" class="img-responsive" src="{{$product->img_paths['medium'] ?? asset('img/small-error-image.png')}}">

                                    <input name="products[]" type="hidden" value="{{$product->id}}">
                                </td>
                                <td>{{$product->title}}</td>
                                <td>
                                    <button type="button" class="btn btn-danger removeProduct"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info">Update</button>
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
