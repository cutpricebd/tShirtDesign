<div class="card text-dark d-none mb-3 text-dark print" style="border: 0">
    <div class="card-body" style="color: #000 !important;">
        <div class="invoice_wrap">
            <div class="i_header">
                <div class="i_logo"><img src="{{$settings_g['logo']}}"></div>
            </div>

            <div class="i_company_info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ici_address">
                            <h2>{{$settings_g['title'] ?? env('APP_NAME')}}</h2>
                            <p class="mb-0">{{$settings_g['street'] ?? ''}}</p>
                            <p class="mb-0">{{$settings_g['city'] ?? ''}}- {{$settings_g['zip'] ?? ''}}, {{$settings_g['state'] ?? ''}}</p>

                            <p class="mb-0">{{$settings_g['mobile_number'] ?? ''}} {{$settings_g['tel'] ? (', Tel: ' . $settings_g['tel']) : ''}}</p>
                            <p class="mb-0">{{$settings_g['email'] ?? ''}}</p>
                            <p class="mb-0">{{ env('APP_WEB_URL') ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ici_order_info">
                            <h2>INVOICE</h2>
                            <p><span>Invoice No</span>: {{$order->id}}</p>
                            <p><span>Invoice Date</span>: {{date('d/m/Y', strtotime($order->created_at))}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="i_customer_info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ic_box">
                            <h2>BILL TO</h2>

                            <p><b><span>Contact Name</span>: {{$order->full_name}}</b></p>
                            <p><span>Address</span><span class="icb_address"><span>:</span> {{$order->full_address}}</span></p>
                            <p><span>Phone</span>: {{$order->mobile_number ?? 'N/A'}}</p>
                            <p><span>Email</span>: {{$order->email ?? 'N/A'}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ic_box">
                            <h2>SHIP TO</h2>

                            <p><b><span>Contact Name</span>: {{$order->shipping_full_name}}</b></p>
                            <p><span>Address</span><span class="icb_address"><span>:</span> {{$order->shipping_full_address}}</span></p>
                            <p><span>Phone</span>: {{$order->shipping_mobile_number ?? 'N/A'}}</p>
                            <p><span>Email</span>: {{$order->shipping_email ?? 'N/A'}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="i_product_info">
                <table class="table table-striped table-hover text-dark mt-3" style="color: #000 !important;">
                    <tbody>
                    <tr id="table_head">
                        <th class="row-1 row-1 tbl-line-height">SL.</th>
                        <th class="row-5 row-4 tbl-line-height">Item Description</th>
                        <th class="row-2 row-3 tbl-line-height" style="width: 220px;">Price</th>
                        <th class="row-1 row-2 tbl-line-height" style="width: 20px;">Qty.</th>
                        <th class="row-2 row-3 tbl-line-height text-right" style="width: 200px;">Total</th>
                    </tr>

                    @foreach($order->OrderProducts as $i => $product)
                        <tr class="{{$i % 2 != 0 ? 'odd' : ''}}">
                            <td class="tbl-line-height">{{ $i + 1 }}</td>
                            <td class="tbl-line-height">{{ $product->Product->title }} {{$product->ProductData->attribute_items_string}}</td>
                            <td class="tbl-line-height">{{($settings_g['currency_symbol'] ?? '$') . $product->sale_price}}</td>
                            <td class="tbl-line-height">{{$product->quantity}}</td>
                            <td class="tbl-line-height text-right">{{($settings_g['currency_symbol'] ?? '$') . ($product->sale_price * $product->quantity)}}</td>
                        </tr>
                    @endforeach

                    @if($order->status == 'Returned' || $order->status == 'Partial')
                    <tr class="return_tr">
                        <th colspan="5" class="text-center">Returned Items</th>
                    </tr>
                    @foreach($order->OrderProducts as $i => $product)
                        @if($product->return_quantity > 0)
                            <tr class="return_tr">
                                <td class="tbl-line-height">{{ $i + 1 }}</td>
                                <td class="tbl-line-height">{{ $product->Product->title }} {{$product->ProductData->attribute_items_string}}</td>
                                <td class="tbl-line-height">{{($settings_g['currency_symbol'] ?? '$') . $product->sale_price}}</td>
                                <td class="tbl-line-height">{{$product->quantity}}</td>
                                <td class="tbl-line-height text-right">{{($settings_g['currency_symbol'] ?? '$') . ($product->sale_price * $product->quantity)}}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr class="return_tr">
                        <td class="tbl-line-height text-right" colspan="4">Total Returned</td>
                        <td class="tbl-line-height text-right">{{($settings_g['currency_symbol'] ?? '$') . ($order->refund_product_total)}}</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="i_footer">
                <div class="row">
                    <div class="col-md-4">
                        <p class="mb-4"><b>Thank you for your Business</b></p>

                        <p class="mb-0"><b>Terms & Conditions</b></p>
                        {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam</p> --}}
                    </div>

                    <div class="col-md-4">
                    </div>

                    <div class="col-md-4">
                        <div class="if_summary">
                            <div class="row">
                                <div class="col-4">
                                    <p><b>Subtotal</b></p>
                                    <p><b>Discount</b></p>
                                    <p><b>Shipping</b></p>
                                    @if($order->refund_shipping_amount)
                                    <p><b>Shipping Refund</b></p>
                                    @endif
                                    @if($order->refund_total_amount)
                                    <p><b>Total Refund</b></p>
                                    @endif
                                </div>

                                <div class="col-8">
                                    <p>: {{ ($settings_g['currency_symbol'] ?? '$') . number_format($order->product_total, 2) }}</p>
                                    <p>: {{ ($settings_g['currency_symbol'] ?? '$') . number_format($order->discount_amount, 2) }}</p>
                                    <p>: {{ ($settings_g['currency_symbol'] ?? '$') . number_format($order->shipping_charge, 2) }}</p>
                                    @if($order->refund_shipping_amount)
                                    <p>: {{ ($settings_g['currency_symbol'] ?? '$') . number_format($order->refund_shipping_amount, 2) }}</p>
                                    @endif
                                    @if($order->refund_total_amount)
                                    <p>: {{ ($settings_g['currency_symbol'] ?? '$') . number_format($order->refund_total_amount, 2) }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="if_summary_total">
                                <div class="row">
                                    <div class="col-4">
                                        <p><h6>TOTAL</h6></p>
                                    </div>

                                    <div class="col-8">
                                        <p><h6>: {{ ($settings_g['currency_symbol'] ?? '$') . number_format($order->grand_total, 2) }}</h6></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-md-6">
                        <div class="i_sign">
                            <h6>Customer Sign</h6>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="i_sign">
                            <h6>Authorized Sign</h6>
                        </div>
                    </div>
                </div> --}}

                <p class="text-center mt-4" style="position: fixed;bottom:100px;left: 0;width:100%;font-weight: bold">Computer generated invoice. No signature required.</p>
            </div>
        </div>
    </div>
</div>
