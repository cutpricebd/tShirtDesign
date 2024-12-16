@extends('back.layouts.master')
@section('title', 'Upload to Google Merchant 2')

@section('head')
<!-- Select -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection

@section('master')
    <div class="card mb-4 shadow">
        <div class="card-header">
            <h5 class="d-inline-block"><b>Upload Product by Category</b></h5>

            <a target="_blank" href="https://developers.google.com/shopping-content/guides/quickstart" class="btn btn-info btn-sm float-right">Get Credentials</a>
        </div>

        <form action="{{route('gm.uploadBSubmit')}}" method="POST">
            @csrf

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Website Category*</b></label>
                            <select class="form-control selectpicker selectCategory" name="website_category" data-live-search="true">
                                <option value="All">Select category</option>
                                @foreach($product_categories as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>

                                    @if(count($category->Categories) > 0)
                                        @foreach($category->Categories as $subCat)
                                            <option value="{{$subCat->id}}">---{{$subCat->title}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Google Category*</b></label>
                            <select class="selectpicker form-control" name="google_category" data-live-search="true">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-info">Submit</button>
            </div>
        </form>
    </div>

    <div class="card mb-4 shadow">
        <div class="card-header">
            <h5 class="d-inline-block mb-0"><b>Pending Items</b></h5>
        </div>

        <div class="card-body overflow-auto">
            <table class="table table-sm table-bordered" id="dataTablePending">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Google Category</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pending_items as $pending_item)
                        <tr>
                            <td>{{count($pending_items) - $loop->index}}</td>
                            <td>#{{$pending_item->product_id}} - {{$pending_item->product->title ?? 'n/a'}}</td>
                            <th>{{$pending_item->google_category->name ?? 'n/a'}}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4 shadow">
        <div class="card-header">
            <h5 class="d-inline-block mb-0"><b>Failed Items</b></h5>
        </div>

        <div class="card-body overflow-auto">
            <table class="table table-sm table-bordered" id="dataTableFailed">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Google Category</th>
                        <th>Failed Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($failed_items as $failed_item)
                        <tr>
                            <td>{{count($failed_items) - $loop->index}}</td>
                            <td>#{{$failed_item->product_id}} - {{$failed_item->product->title ?? 'n/a'}}</td>
                            <th>{{$failed_item->google_category->name ?? 'n/a'}}</th>
                            <th>{{$failed_item->failed_note}}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4 shadow">
        <div class="card-header">
            <h5 class="d-inline-block mb-0"><b>Uploaded Items</b></h5>
        </div>

        <div class="card-body overflow-auto">
            <table class="table table-sm table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Google Category</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($uploaded_items as $uploaded_item)
                        <tr>
                            <td>{{count($uploaded_items) - $loop->index}}</td>
                            <td>#{{$uploaded_item->product_id}} - {{$uploaded_item->product->title ?? 'n/a'}}</td>
                            <th>{{$uploaded_item->google_category->name ?? 'n/a'}}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    <!-- Select 2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        // Select2
        $('.selectpicker').selectpicker();


        $('#dataTablePending').DataTable({
            "order": [[0, "desc"]]
        });
        $('#dataTableFailed').DataTable({
            "order": [[0, "desc"]]
        });
        $('#dataTable').DataTable({
            "order": [[0, "desc"]]
        });
    </script>
@endsection
