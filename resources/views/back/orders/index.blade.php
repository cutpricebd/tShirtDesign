
@php
    $ref = request('ref') ?? 'All';
@endphp

@extends('back.layouts.master')
@section('title', "$ref Orders")

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Order list</h5>

        <a href="{{route('back.orders.exportCsv')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-download"></i> Export CSV</a>
    </div>
    <form action="{{route('back.orders.printList')}}" method="POST">
        @csrf

        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm" id="dataTable">
                <thead>
                  <tr>
                    <th scope="col">
                        <input class="mt-1 all_checkbox float-left mr-2" id="mark_all" type="checkbox" value="Yes" style="width: 20px;height:20px">
                        <label for="mark_all">Select</label>
                    </th>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Shipping Name</th>
                    <th scope="col">Shipping Address</th>
                    <th scope="col">Shipping Mobile Number</th>
                    <th scope="col">Order Total Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col" class="text-right">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-sm btn-success mt-4" name="btn_type" value="print"><i class="fas fa-print"></i> Print Selected</button>

                    {{-- @if($ref == 'Confirmed' && (settings('courier', 'enable_courier') ?? 'No') == 'Yes')
                    <br>
                    @if(($courier_config['steadfast_enabled'] ?? '') == 'Yes')
                    <button class="btn btn-sm btn-info mt-4" name="btn_type" value="steadfast_bulk">Send SteadFast</button>
                    @endif
                    @if(($courier_config['pathao_enabled'] ?? '') == 'Yes')
                    <button class="btn btn-sm btn-info mt-4" name="btn_type" value="pathao_bulk">Send Pathao</button>
                    @endif
                    @if(($courier_config['redx_enabled'] ?? '') == 'Yes')
                    <button class="btn btn-sm btn-info mt-4" name="btn_type" value="redx_bulk">Send Redx</button>
                    @endif
                    @endif --}}
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Change Status*</b></label>

                        <select name="status" class="form-control form-control-sm">
                            <option value="" >Select Status</option>
                            <option value="Processing">Processing</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Completed">Completed</option>
                            <option value="Canceled">Canceled</option>
                            <option value="Returned">Returned</option>
                        </select>
                    </div>

                    <button class="btn btn-sm btn-info" name="type" value="status_update">Change Selected</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

<script>
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('back.orders.table')}}",
            "dataType": "json",
            "type": "POST",
            "data": {_token: "{{csrf_token()}}", status: '{{$ref}}'}
        },
        "columns": [
            {"data": "select"},
            {"data": "id"},
            {"data": "date"},
            {"data": "order_name"},
            {"data": "full_address"},
            {"data": "mobile_number"},
            {"data": "total_amount"},
            {"data": "status"},
            {"data": "payment_status"},
            {"data": "action"}
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "order": [[1, "desc"]],
        "columnDefs": [
            { orderable: true, className: 'reorder', targets: [1] },
            { orderable: false, targets: '_all' }
        ]
    });

    $(document).on('change', '#mark_all', function(){
        if($(this).prop('checked')){
            $('.checkbox_items').prop('checked', true);
        }else{
            $('.checkbox_items').prop('checked', false);
        }
    });
</script>
@endsection
