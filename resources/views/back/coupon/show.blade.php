@extends('back.layouts.master')
@section('title', 'Coupon Details')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-font-color-light bg-info mb-3 custom_dashboard_card">
                <div class="card-body">
                  <div class="row">
                      <div class="col-9">
                        <h1 class="card-title">{{count($coupon->Orders)}}</h1>
                        <p class="card-text">Total Used</p>
                      </div>

                      <div class="col-3 text-right">
                          <i class="fas fa-list cdc_icon"></i>
                      </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-font-color-light bg-success mb-3 custom_dashboard_card">
                <div class="card-body">
                  <div class="row">
                      <div class="col-9">
                        <h1 class="card-title">{{($settings_g['currency_symbol'] ?? '$') . $coupon->used_amount}}</h1>
                        <p class="card-text">Total Used Amount</p>
                      </div>

                      <div class="col-3 text-right">
                          <i class="fas fa-dollar-sign cdc_icon"></i>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-light mt-3 shadow">
        <div class="card-header">
            <h5 class="d-inline-block">History</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm" id="dataTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Order Name</th>
                    <th scope="col">Coupon Amount</th>
                    <th scope="col" class="text-right">Payment Status</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($coupon->Orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{date('d/m/Y', strtotime($order->created_at))}}</td>
                            <td>{{$order->full_name}}</td>
                            <td>{{($settings_g['currency_symbol'] ?? '$') . number_format($order->discount_amount, 2)}}</td>
                            <td class="text-right">{{$order->payment_status}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

<script>
    $(document).ready( function () {
        $('#dataTable').DataTable({
            order: [[0, "desc"]],
        });
    });
</script>
@endsection
