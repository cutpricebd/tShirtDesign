@extends('back.layouts.master')
@section('title', 'Coupons report')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light shadow mb-4">
    <form action="{{route('back.report.coupon')}}" method="GET">
        <div class="card-header">
            <h5 class="d-inline-block">Filter</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label><b>Coupon Code</b></label>
                        <select name="coupon_code" class="form-control form-control-sm coupon_code">
                            <option value="" {{!request('coupon_code') ? 'selected' : ''}}>Any Code</option>
                            @foreach ($coupons as $coupon)
                                <option value="{{$coupon->code}}" {{request('coupon_code') == $coupon->code ? 'selected' : ''}}>{{$coupon->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label><b>From Date</b></label>
                        <input type="date" name="from_date" value="{{request('from_date')}}" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label><b>To Date</b></label>
                        <input type="date" name="to_date" value="{{request('to_date')}}" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label style="visibility: hidden">.</label>
                        <br>
                        <button name="type" value="filter" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button name="type" value="excel" class="btn btn-primary"><i class="fas fa-table"></i> Export Excel</button>
            <button name="type" value="pdf" class="btn btn-success"><i class="fas fa-sticky-note"></i> Export PDF</button>
            <a href="{{route('back.report.coupon')}}" class="btn btn-info"><i class="fas fa-undo-alt"></i> Reset</a>
        </div>
    </form>
</div>

<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">History</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col" style="width: 50px">SL.</th>
                <th scope="col">Order ID</th>
                <th scope="col">Date</th>
                <th scope="col">Code</th>
                <th scope="col">Discount Amount</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

<script>
    // Datatable
    let status = "PaidCoupon";
    let from_date = "{{request('from_date')}}";
    let to_date = "{{request('to_date')}}";
    let coupon_code = "{{request('coupon_code')}}";

    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax": {
            "url": "{{route('back.orders.table')}}",
            "dataType": "json",
            "type": "POST",
            "data": {_token: "{{csrf_token()}}", status, from_date, to_date, coupon_code}
        },
        "columns": [
            {"data": "sl_desc"},
            {"data": "id"},
            {"data": "date"},
            {"data": "coupon_code"},
            {"data": "discount_amount"}
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "order": [[0, "desc"]],
        "columnDefs": [
            { orderable: true, className: 'reorder', targets: [0] },
            { orderable: false, targets: '_all' }
        ]
    });
</script>
@endsection
