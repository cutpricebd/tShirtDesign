@extends('back.layouts.master')
@section('title', "Invoice: #$order->id-$order->status")

@section('head')
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- Select 2 -->
{{-- <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css"> --}}

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="{{asset('back/percentage-circles/dist/percircle.css')}}">
@endsection

@section('master')
<form action="{{route('back.orders.update', $order->id)}}" method="POST" enctype="multipart/form-data">
@csrf
@method('PATCH')

{{-- <div class="card border-light mt-3 shadow noPrint">
    <div class="card-header">
        <h6 class="d-inline-block">Billing Address</h6>

        <button class="btn btn-info btn-sm float-right" onclick="window.print();" type="button"><i class="fas fa-print"></i> Print Order</button>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label><b>Reference No</b></label>
                    <input type="text" class="form-control form-control-sm" value="{{$order->reference_no ?? 'N/A'}}" disabled>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label><b>Customer Full Name</b></label>
                    <input type="text" class="form-control form-control-sm" value="{{$order->full_name}}" disabled>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label><b>Email</b></label>
                    <input type="text" class="form-control form-control-sm" value="{{$order->email}}" disabled>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label><b>Mobile Number</b></label>
                    <input type="text" class="form-control form-control-sm" value="{{$order->mobile_number}}" disabled>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Street</b></label>
                    <input type="text" class="form-control form-control-sm" name="street" value="{{old('street') ?? $order->street}}" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><b>Postal Code</b></label>
                    <input type="text" class="form-control form-control-sm" name="zip" value="{{old('zip') ?? $order->zip}}" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><b>City</b></label>
                    <input type="text" class="form-control form-control-sm" name="city" value="{{old('city') ?? $order->city}}" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><b>Province</b></label>
                    <input type="text" class="form-control form-control-sm" name="state" value="{{old('state') ?? $order->state}}" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><b>Country</b></label>
                    <input type="text" class="form-control form-control-sm" name="country" value="{{old('country') ?? $order->country}}" disabled>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="card border-light mt-3 shadow noPrint">
    <div class="card-header">
        <h6 class="d-inline-block">Shipping Address</h6>

        <button class="btn btn-info btn-sm float-right" onclick="window.print();" type="button"><i class="fas fa-print"></i> Print Order</button>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label><b>Full Name*</b></label>
                    <input type="text" class="form-control form-control-sm" name="name" value="{{$order->shipping_full_name}}" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label><b>Email</b></label>
                    <input type="text" class="form-control form-control-sm" name="email" value="{{$order->shipping_email}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label><b>Mobile Number*</b></label>
                    <input type="text" class="form-control form-control-sm" name="mobile_number" value="{{$order->shipping_mobile_number}}" required>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Address*</b></label>
                    <input type="text" class="form-control form-control-sm" name="address" value="{{old('address') ?? $order->shipping_street}}" required>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mt-3 courier_status_wrap" style="display: none">
    <div class="card-header">
        <h6 class="mb-0">Courier Success Rate</h6>
    </div>

    <div class="card-body"></div>
</div>

<div class="row noPrint">
    <div class="col-md-8">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h6 class="mb-0 d-inline-block">Order Products</h6>

                <button type="button" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#exampleModal">Add Product</button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <h5>Purchased Items</h5>
                    <table class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Image</th>
                            <th scope="col" class="text-center" style="width: 120px">Unit Price</th>
                            <th scope="col" class="text-center" style="width: 120px">Quantity</th>
                            <th scope="col" style="width: 120px" class="text-right">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody class="listed_items">
                            @foreach ($order->OrderProducts as $order_product)
                                <tr>
                                    <td>
                                        {{$order_product->Product->title}}
                                        <input type="hidden" name="order_product[]" value="{{$order_product->id}}">

                                        @if($order_product->attribute_items_string)
                                        <p class="mb-0"><small>{{$order_product->attribute_items_string}}</small></p>
                                        @endif
                                    </td>
                                    <td class="text-center"><img src="{{$order_product->Product->img_paths['small']}}" style="width:35px"></td>
                                    <td class="text-center">{{'৳ ' . $order_product->sale_price}}</td>
                                    <td class="text-center"><input type="number" name="quantity[]" required class="form-control form-control-sm" value="{{$order_product->quantity}}"></td>
                                    <td class="text-right">{{'৳ ' . ($order_product->quantity * $order_product->sale_price)}}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <th class="text-right" colspan="4">Total</th>
                                <th class="text-right">{{'৳ ' . $order->product_total}}</th>
                            </tr>
                        </tbody>
                    </table>

                    @if($order->status == 'Returned' || $order->status == 'Partial')
                    <h5>Returned Items</h5>
                    <table class="table table-bordered table-sm table-danger">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Image</th>
                            <th scope="col" class="text-center">Variation</th>
                            <th scope="col" class="text-center" style="width: 120px">Unit Price</th>
                            <th scope="col" class="text-center" style="width: 120px">Quantity</th>
                            <th scope="col" style="width: 120px" class="text-right">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody class="listed_items">
                            @foreach ($order->OrderProducts as $order_product)
                                @if($order_product->return_quantity > 0)
                                    <tr>
                                        <td>{{$order_product->Product->title}}</td>
                                        <td class="text-center"><img src="{{$order_product->Product->img_paths['small']}}" style="width:35px"></td>
                                        <td class="text-center">{{$order_product->ProductData->attribute_items_string ?? 'N/A'}}</td>
                                        <td class="text-center">{{($settings_g['currency_symbol'] ?? '$') . $order_product->sale_price}}</td>
                                        <td class="text-center">{{$order_product->return_quantity}}</td>
                                        <td class="text-right">{{($settings_g['currency_symbol'] ?? '$') . ($order_product->return_quantity * $order_product->sale_price)}}</td>
                                    </tr>
                                @endif
                            @endforeach

                            <tr>
                                <th class="text-right" colspan="5">Total</th>
                                <th class="text-right">{{($settings_g['currency_symbol'] ?? '$') . $order->refund_product_total}}</th>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Order Status*</b></label>

                            <select name="status" class="form-control form-control-sm" {{($order->status == 'Returned' || $order->status == 'Partial' || $order->status == 'Completed') ? 'disabled' : 'required'}}>
                                <option value="Processing" {{$order->status == 'Processing' ? 'selected' : ''}}>Processing</option>
                                <option value="Confirmed" {{$order->status == 'Confirmed' ? 'selected' : ''}}>Confirmed</option>
                                <option value="Shipped" {{$order->status == 'Shipped' ? 'selected' : ''}}>Shipped</option>
                                <option value="Delivered" {{$order->status == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                <option value="Completed" {{$order->status == 'Completed' ? 'selected' : ''}}>Completed</option>
                                @if($order->status == 'Returned')
                                <option value="Returned" {{$order->status == 'Returned' ? 'selected' : ''}}>Returned</option>
                                @endif
                                @if($order->status == 'Partial')
                                <option value="Partial" {{$order->status == 'Partial' ? 'selected' : ''}}>Partial</option>
                                @endif
                                @if(($order->status == 'Canceled' || $order->status == 'Processing') && ($order->payment_status == 'Pending' || $order->payment_status == 'Due'))
                                <option value="Canceled" {{$order->status == 'Canceled' ? 'selected' : ''}}>Canceled</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Payment Status*</b></label>

                            <select name="payment_status" class="form-control form-control-sm" {{($order->payment_status == 'Paid' || $order->payment_status == 'Refunded') ? 'disabled' : 'required'}}>
                                {{-- <option value="Pending" {{$order->payment_status == 'Pending' ? 'selected' : ''}}>Pending</option> --}}
                                <option value="Due" {{$order->payment_status == 'Due' ? 'selected' : ''}}>Due</option>
                                {{-- <option value="Partial" {{$order->payment_status == 'Partial' ? 'selected' : ''}}>Partial</option> --}}
                                <option value="Paid" {{$order->payment_status == 'Paid' ? 'selected' : ''}}>Paid</option>
                                @if($order->payment_status == 'Refunded')
                                <option value="Refunded" {{$order->payment_status == 'Refunded' ? 'selected' : ''}}>Refunded</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Payment Method</b></label>

                            <select name="payment_method" class="form-control form-control-sm" {{$order->payment_status == 'Paid' ? 'disabled' : 'required'}}>
                                <option value="Visa/Master">Visa/Master</option>
                                <option value="PayPal">PayPal</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block"><b>Attachments</b>
                                @if($order->attachment)
                                    <a href="{{$order->attachment_path}}" class="btn btn-success btn-sm float-right" download=""><i class="fas fa-download"></i></a>
                                @endif
                            </label>

                            <input type="file" name="attachment">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Order Note</b></label>
                            <textarea name="note" class="form-control form-control-sm" cols="30" rows="5">{{$order->note}}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Staff Note</b></label>
                            <textarea name="staff_note" class="form-control form-control-sm" cols="30" rows="5">{{$order->staff_note}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(count($order->OrderPayments))
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h6 class="mb-0">Order Payments</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Date</th>
                            <th scope="col">TXN Number</th>
                            {{-- <th scope="col">Status</th> --}}
                            <th scope="col" class="text-right">Note</th>
                        </tr>
                        </thead>
                        <tbody class="listed_items">
                            @foreach ($order->OrderPayments as $key => $order_payment)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{date('d/m/Y h:ia', strtotime($order_payment->created_at))}}</td>
                                    <td>{{$order_payment->txn_number}}</td>
                                    {{-- <td>{{$order_payment->status}}</td> --}}
                                    <td class="text-right">{{$order_payment->note}}</td>
                                    {{-- <td class="text-right">
                                        @if($order_payment->status == 'Active')
                                        <a href="{{route('back.orders.refund', $order_payment->id)}}" onclick="return confirm('Are you sure to refund?');" class="btn btn-danger btn-sm">Refund</a>
                                        @else
                                        N/A
                                        @endif
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h6 class="mb-0">Summary</h6>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Subtotal:</th>
                        <td class="text-right">
                            <span class="product_sub_total">{{($settings_g['currency_symbol'] ?? '$') . number_format($order->product_total, 2)}}</span>
                            <input type="hidden" name="product_total" class="product_total_input" value="0">
                        </td>
                    </tr>
                    <tr>
                        <th>Discount:</th>
                        <td class="text-right" style="width: 150px">
                            {{-- {{($settings_g['currency_symbol'] ?? '$') . number_format($order->discount_amount, 2)}} --}}
                            <input type="text" class="form-control form-control-sm summary_input discount_input" name="discount" value="{{$order->discount_amount ?? 0}}" required>
                        </td>
                    </tr>
                    @if($order->discount_amount)
                    <tr>
                        <th>After Discount:</th>
                        <td class="text-right">
                            <span class="after_discount">{{($settings_g['currency_symbol'] ?? '$') . number_format($order->product_total - $order->discount_amount, 2)}}</span>
                            {{-- <input type="hidden" name="discount_amount" value="0" class="discount_amount"> --}}
                        </td>
                    </tr>
                    @endif
                    {{-- <tr>
                        <th>HST ({{$order->tax}}%):</th>
                        <td class="text-right">
                            <span class="tax_amount">{{($settings_g['currency_symbol'] ?? '$') . number_format($order->tax_amount, 2)}}</span>
                            <input type="hidden" name="tax_amount" class="tax_amount_input" value="0">
                        </td>
                    </tr> --}}
                    <tr>
                        <th>Shipping Method:</th>
                        <td class="text-right" style="width: 150px">
                            {{$order->shipping_method}}
                        </td>
                    </tr>

                    <tr>
                        <th>Shipping Charge:</th>
                        <td class="text-right" style="width: 150px">
                            <input type="number" name="shipping_charge" class="form-control" value="{{$order->shipping_charge}}">
                        </td>
                    </tr>

                    @if($order->refund_shipping_amount)
                    <tr>
                        <th>Shipping Refund:</th>
                        <td class="text-right" style="width: 150px">
                            {{($settings_g['currency_symbol'] ?? '$') . number_format($order->refund_shipping_amount, 2)}}
                        </td>
                    </tr>
                    @endif
                    @if($order->refund_tax_amount)
                    <tr>
                        <th>HST Refund:</th>
                        <td class="text-right" style="width: 150px">
                            {{($settings_g['currency_symbol'] ?? '$') . number_format($order->refund_tax_amount, 2)}}
                        </td>
                    </tr>
                    @endif
                    @if($order->refund_total_amount)
                    <tr>
                        <th>Total Refund:</th>
                        <td class="text-right" style="width: 150px">
                            {{($settings_g['currency_symbol'] ?? '$') . number_format($order->refund_total_amount, 2)}}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>Grand Total:</th>
                        <td class="text-right">
                            <span class="grand_total">{{($settings_g['currency_symbol'] ?? '$') . number_format($order->grand_total, 2)}}</span>
                            {{-- <input type="hidden" name="grand_total" class="grand_total_input" value="0"> --}}
                        </td>
                    </tr>

                    @if($order->courier_invoice)
                    <tr>
                        <th>Courier:</th>
                        <td>
                            {{$order->courier}}
                        </td>
                    </tr>
                    <tr>
                        <th>Courier Invoice:</th>
                        <td>
                            <a href="{{$order->tracking_link}}" target="_blank">{{$order->courier_invoice}}</a>
                        </td>
                    </tr>
                    <tr>
                        <th>Courier Status:</th>
                        <td>
                            {{$order->courier_status}}
                        </td>
                    </tr>
                    @endif
                </table>
            </div>

            <div class="card-footer">
                <div class="mb-3">
                    <button class="btn btn-success">Update</button>
                </div>

                @if((settings('courier', 'enable_courier') ?? 'No') == 'Yes')
                    @if(!$order->courier_invoice)
                    <div class="courier_btn_group">
                        @if(($courier_config['pathao_enabled'] ?? '') == 'Yes')
                        <button class="btn btn-success btn-block mt-2 pathaoModalBtn" data-type="1" type="button"><i class="fas fa-truck"></i> Send to Pathao</button>
                        <button class="btn btn-primary btn-block mt-2 pathaoModalBtn" data-type="2" type="button"><i class="fas fa-truck"></i> Send to Pathao 2</button>
                        @endif

                        @if(($courier_config['redx_enabled'] ?? '') == 'Yes')
                            <button class="btn btn-primary btn-block mt-2 redxModalBtn" type="button"><i class="fas fa-truck"></i> Send to REDX</button>
                        @endif

                        @if(($courier_config['steadfast_enabled'] ?? '') == 'Yes')
                            <button class="btn btn-info btn-block mt-2" data-toggle="modal" data-target="#steadfastModal" type="button"><i class="fas fa-truck"></i> Send to Steadfast</button>
                        @endif

                        @if(($courier_config['ecourier_enabled'] ?? '') == 'Yes')
                            <button class="btn btn-danger btn-block mt-2 eCourierModalBtn" type="button"><i class="fas fa-truck"></i> Send to eCourier</button>
                        @endif

                        @if(($courier_config['paperfly_enabled'] ?? '') == 'Yes')
                            <button class="btn btn-warning btn-block mt-2" data-toggle="modal" data-target="#paperflyModal" type="button"><i class="fas fa-truck"></i> Send to Paperfly</button>
                        @endif

                        @if(($courier_config['pidex_enabled'] ?? '') == 'Yes')
                            <button class="btn btn-secondary btn-block mt-2" onclick="return cAlert('error', 'Pidex API error!');" type="button"><i class="fas fa-truck"></i> Send to Pidex</button>
                        @endif
                    </div>
                    @endif

                    @if($order->courier_invoice && ($order->status == 'Delivered' || $order->status == 'In Courier'))
                    <a href="{{route('orders.updateCourierStatus', $order->id)}}" class="btn btn-success btn-block mt-2">Update Courier Status</a>
                    @endif
                @endif

                <button class="btn btn-info mt-2" onclick="window.print();" type="button"><i class="fas fa-print"></i> Invoice Print</button>
                {{-- <a class="btn btn-info" target="_blank" href="{{route('orderLabelPrint', $order->id)}}" type="button"><i class="fas fa-print"></i> Label Print</a> --}}
                <br>
                <small><b>NB: *</b> marked are required field.</small>
            </div>
        </div>
    </div>
</div>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Product to Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('back.orders.addProduct', $order->id)}}" method="POST">
            @csrf

            <div class="modal-body">
                <select name="product" class="form-control form-control-sm category selectpicker" style="width: 100%" required>
                    <option value="">Select category</option>

                    @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm">Add</button>
            </div>
        </form>
      </div>
    </div>
</div>

@include('back.orders.print2', [
    'for' => 'admin'
])
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <script src="{{asset('back/percentage-circles/dist/percircle.js')}}"></script>

    <!-- Select 2 -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Select2
        // $('.selectpicker').selectpicker();
        $('.selectpicker').select2({
            dropdownParent: $("#exampleModal")
        });

        function getCourierSuccessRate(){
            $('.courier_status_wrap').show();
            $('.courier_status_wrap .card-body').html(`<div class="text-center">
                <i class="fas fa-spinner fa-spin" style="font-size: 30px;margin-top: 20px;"></i>
            </div>`);

            $.ajax({
                url: '{{route("orders.getSuccessRate")}}',
                method: 'POST',
                data: {_token: "{{csrf_token()}}", mobile_number: "{{$order->shipping_mobile_number}}"},
                success: function(result){
                    $('.courier_status_wrap .card-body').html(result);
                },
                error: function(){
                    $('.courier_status_wrap').hide();
                    console.log('Courier data fetch error!');
                }
            });
        }
        getCourierSuccessRate();
    </script>

    @if(!$order->courier_invoice)
    @if(($courier_config['pathao_enabled'] ?? '') == 'Yes')
    <div id="pathaoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pathaoModalLabel"
    aria-hidden="true" style="padding-bottom: 40px;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pathaoModalLabel">Send to Pathao</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('orders.sendPathaoOrder', $order->id)}}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><b>Store*</b></label>
                                    <select class="form-control pathao_stores" name="store" required>
                                        <option value="">Select Store</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pathao_loactions"></div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><b>Shipping Address*</b></label>
                                    <input type="text" name="address" value="{{$order->shipping_street}}" class="form-control" required>
                                    <p><small>Address should be in English only!</small></p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Shipping Mobile Number*</b></label>
                                    <input type="text" class="form-control pathao_phone_number" name="phone_number" value="{{$order->shipping_mobile_number}}">
                                    <p><small>Mobile Number should be in English only & please remove +88 from mobile number!</small></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><b>Shipping Note</b></label>
                                    <input type="text" class="form-control pathao_shipping_note" value="{{$order->note}}" name="note">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>Collect Amount*</b></label>
                                    <input type="number" step="any" class="form-control pathao_collect_amount" value="{{$order->grand_total}}" name="collect_amount" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Weight*</b></label>
                                    <select name="weight" class="form-control" name="weight" required>
                                        <option value="0.5">0.5Kg</option>
                                        <option value="1">1Kg</option>
                                        <option value="2">2</option>
                                        <option value="3">3Kg</option>
                                        <option value="4">4Kg</option>
                                        <option value="5">5Kg</option>
                                        <option value="6">6Kg</option>
                                        <option value="7">7Kg</option>
                                        <option value="8">8Kg</option>
                                        <option value="9">9Kg</option>
                                        <option value="10">10Kg</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.pathaoModalBtn', function(){
            let type = $(this).data('type');

            cLoader();
            $.ajax({
                url: '{{route("orders.getPathaoInfo")}}',
                method: 'POST',
                dataType: 'json',
                data: {_token: "{{csrf_token()}}", type},
                success: function(result){
                    cLoader('hide');

                    if(result.status){
                        $('.pathao_stores').html(result.stores);
                        $('.pathao_loactions').html(result.locations_html);

                        $('#pathaoModal').modal('show');
                    }else{
                        cAlert('error', 'Error from Pathao API!');
                    }
                },
                error: function(){
                    cLoader('hide');

                    cAlert('error', 'Error from Pathao API!');
                }
            });
        });

        $(document).on('change', '.city_select', function(){
            let city_id = $(this).val();

            $('.zone_select').html('<option value="">Select Zone</option>');
            $('.area_select').html('<option value="">Select Area</option>');

            cLoader();

            $.ajax({
                url: '{{route("orders.getPathaoZone")}}',
                method: "POST",
                data: {city_id, _token: "{{csrf_token()}}"},
                success: function(response){
                    cLoader('hide');

                    if(response == 'false'){
                        cAlert('error', 'Error from Pathao API!');
                    }else{
                        $('.zone_select').html(response);
                    }
                },
                error: function(){
                    cLoader('hide');

                    cAlert('error', 'Error from Pathao API!');
                }
            });
        });

        $(document).on('change', '.zone_select', function(){
            let zone_id = $(this).val();

            $('.area_select').html('<option value="">Select Area</option>');

            cLoader();

            $.ajax({
                url: '{{route("orders.getPathaoAreas")}}',
                method: "POST",
                data: {zone_id, _token: "{{csrf_token()}}"},
                success: function(response){
                    cLoader('hide');

                    if(response == 'false'){
                        cAlert('error', 'Error from Pathao API!');
                    }else{
                        $('.area_select').html(response);
                    }
                },
                error: function(){
                    cLoader('hide');

                    cAlert('error', 'Error from Pathao API!');
                }
            });
        });
    </script>
    @endif

    @if(($courier_config['redx_enabled'] ?? '') == 'Yes')
    <div id="redexModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="redexModalLabel"
    aria-hidden="true" style="padding-bottom: 40px;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="redexModalLabel">Submit to REDX</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('orders.sendRedexOrder', $order->id)}}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="redex_info_html"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Customer Mobile Number*</b></label>
                                    <input type="text" class="form-control" name="phone_number" value="{{ $order->shipping_mobile_number }}">
                                    <p><small>Mobile Number should be in English only</small></p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Weight*</b></label>
                                    <select name="weight" class="form-control" name="weight" required>
                                        <option value="500">0.5Kg</option>
                                        <option value="1000">1Kg</option>
                                        <option value="2000">2</option>
                                        <option value="3000">3Kg</option>
                                        <option value="4000">4Kg</option>
                                        <option value="5000">5Kg</option>
                                        <option value="6000">6Kg</option>
                                        <option value="7000">7Kg</option>
                                        <option value="8000">8Kg</option>
                                        <option value="9000">9Kg</option>
                                        <option value="10000">10Kg</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Collect Amount*</b></label>
                                    <input type="number" step="any" class="form-control pathao_collect_amount" value="{{$order->grand_total}}" name="collect_amount" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><b>Shipping Address*</b></label>
                            <input type="text" name="address" class="form-control" value="{{ $order->shipping_street }}" required>
                            <p><small>Address should be in English only</small></p>
                        </div>

                        <div class="form-group">
                            <label><b>Shipping Note</b></label>
                            <input type="text" class="form-control" name="note" value="{{ $order->note }}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.redxModalBtn', function(){
            cLoader();
            $.ajax({
                url: '{{route("orders.getRedexInfo")}}',
                method: 'POST',
                dataType: 'json',
                data: {_token: "{{csrf_token()}}"},
                success: function(result){
                    cLoader('hide');

                    if(result.status){
                        $('.redex_info_html').html(result.html);

                        $('#redexModal').modal('show');
                    }else{
                        cAlert('error', 'Error from API!');
                    }
                },
                error: function(){
                    cLoader('hide');

                    cAlert('error', 'Error from API!');
                }
            });
        });
    </script>
    @endif

    @if(($courier_config['steadfast_enabled'] ?? '') == 'Yes')
    <div id="steadfastModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="steadfastModalLabel"
    aria-hidden="true" style="padding-bottom: 40px;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="steadfastModalLabel">Submit to Steadfast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('orders.sendSteadfastOrder', $order->id)}}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Collect Amount*</b></label>
                                    <input type="number" step="any" class="form-control pathao_collect_amount" value="{{$order->grand_total}}" name="collect_amount" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Customer Mobile Number*</b></label>
                                    <input type="text" class="form-control" name="phone_number" value="{{ $order->shipping_mobile_number }}">
                                    <p><small>Mobile Number should be in English only</small></p>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><b>Shipping Address*</b></label>
                                    <input type="text" name="address" class="form-control" value="{{ $order->shipping_street }}" required>
                                    <p><small>Address should be in English only</small></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><b>Shipping Note</b></label>
                            <input type="text" class="form-control" name="note" value="{{ $order->note }}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endif
@endsection
