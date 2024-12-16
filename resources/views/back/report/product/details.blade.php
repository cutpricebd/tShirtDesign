@extends('back.layouts.master')
@section('title', 'Product Details Report')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Sales History of "{{$product->title}}"</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Sale Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Variation</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($product->OrderProducts as $order_product)
                    <tr>
                        <td>{{$order_product->id}}</td>
                        <td>{{date('d/m/Y', strtotime($order_product->created_at))}}</td>
                        <td>{{$order_product->sale_price}}</td>
                        <td>{{$order_product->quantity}}</td>
                        <td>{{$order_product->attribute_item_ids ? $order_product->ProductData->attribute_items_string : 'N/A'}}</td>
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
    $('#dataTable').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "order": [[0, "desc"]]
    });
</script>
@endsection
