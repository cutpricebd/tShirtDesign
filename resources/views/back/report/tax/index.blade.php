@extends('back.layouts.master')
@section('title', 'Tax Report')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-font-color-light bg-success mb-3 custom_dashboard_card overflow-hidden">
                <div class="card-body">
                  <div class="row">
                      <div class="col-9">
                        <h1 class="card-title">{{($settings_g['currency_symbol'] ?? '$') . number_format($total_tax_amount, 2)}}</h1>
                        <p class="card-text">Total Tax Amount</p>
                      </div>

                      <div class="col-3 text-right">
                          <i class="fas fa-dollar-sign cdc_icon"></i>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-light shadow mb-4">
        <form action="{{route('back.report.taxes')}}" method="GET">
            <div class="card-header">
                <h5 class="d-inline-block">Filter</h5>
            </div>

            <div class="card-body">
                <div class="row">
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
                <a href="{{route('back.report.taxes')}}" class="btn btn-info"><i class="fas fa-undo-alt"></i> Reset</a>
            </div>
        </form>
    </div>

    <div class="card border-light mt-3 shadow">
        <div class="card-header">
            <h5 class="d-inline-block">Tax History</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm" id="dataTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Order Name</th>
                    <th scope="col">Tax Amount</th>
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
    let from_date = "{{request('from_date')}}";
    let to_date = "{{request('to_date')}}";

    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('back.orders.table')}}",
            "dataType": "json",
            "type": "POST",
            "data": {_token: "{{csrf_token()}}", status: 'CompletedTax', from_date, to_date}
        },
        "columns": [
            {"data": "sl_desc"},
            {"data": "date"},
            {"data": "order_name"},
            {"data": "tax_amount"}
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
