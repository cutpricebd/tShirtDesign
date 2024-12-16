<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Mail\OrderRefundMail;
use App\Models\Order\Order;
use App\Models\Order\OrderProduct;
use App\Models\OrderPayment;
use App\Models\Product\Product;
use App\Models\User;
use App\Repositories\AccountsRepo;
use App\Repositories\eShipperRepo;
use App\Repositories\mpgClasses;
use App\Repositories\OrderRepo;
use App\Repositories\StockRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Info;
use App\Exports\OrderExport;
use App\Repositories\PaperflyRepo;
use App\Repositories\PathaoRepo;
use App\Repositories\RedxRepo;
use App\Repositories\SteadFastRepo;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Order::where('admin_read', 2)->update(['admin_read' => 1]);
        $courier_config = Info::SettingsGroupKey('courier');

        return view('back.orders.index', compact('courier_config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'required',
            'products' => 'required',
            'status' => 'required',
            'payment_status' => 'required',
            'discount' => 'required',
            'shipping' => 'required',
        ]);

        $user = User::find($request->customer);

        $order = new Order;

        // Statuses
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;

        // Customer Information
        $order->user_id = $request->customer;
        $order->first_name = $user->first_name;
        $order->last_name = $user->last_name;
        $order->street = $user->street;
        $order->apartment = $user->apartment;
        $order->city = $user->city;
        $order->state = $user->state;
        $order->zip = $user->zip;
        $order->country = $user->country;
        $order->mobile_number = $user->mobile_number;
        $order->email = $user->email;

        // Customer Shipping Information
        $order->shipping_full_name = $user->full_name;
        $order->shipping_email = $user->email;
        $order->shipping_mobile_number = $user->mobile_number;
        $order->shipping_street = $user->state;
        $order->shipping_post_code = $user->zip;
        $order->shipping_city = $user->city;
        $order->shipping_state = $user->state;
        $order->shipping_country = $user->country;

        // Charges
        $order->product_total = $request->product_total;

        // $order->tax = Info::Settings('settings', 'tax') ?? 0;
        $order->tax_amount = $request->tax_amount ?? 0;

        $order->discount = $request->discount;
        $order->discount_amount = $request->tax_amount;
        if($request->payment_method){
            $order->payment_method = $request->payment_method;
        }

        // Shipping
        $order->shipping_charge = $request->shipping;
        // $order->shipping_weight = $cart_summary['shipping_weight'];

        // Notes
        $order->note = $request->note;
        $order->staff_note = $request->staff_note;

        // Others
        $order->reference_no = $request->reference_no;

        // Attachment
        if ($request->file('attachment')){
            // $this->validate($request, [
            //     'image' => 'image|mimes:jpg,png,jpeg,gif'
            // ]);
            $file = $request->file('attachment');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/order';
            $file->move($destination, $file_name);
            $order->attachment = $file_name;
        }

        $order->save();

        if($request->payment_status == 'Paid'){
            OrderRepo::paid($order->id);

            // Shipping Request
            eShipperRepo::create($order->shipping_street, $order->shipping_city, $order->shipping_state, $order->shipping_post_code, $order->phone_number, $order->shipping_email);

            AccountsRepo::accounts('Credit', $order->grand_total, "Order Payment #$order->id");
        }

        // Insert Order Status
        OrderRepo::status($order->id, 'Order created', auth()->user()->full_name);

        // Insert order products
        foreach($request->products as $key => $product){
            $total_shipping_weight = 0;
            if($request->quantity[$key] > 0){
                $order_product = OrderRepo::product($order->id, $product, $request->product_data_id[$key], $request->price[$key], $request->quantity[$key]);

                // Shipping weightShipping weight calculation
                $total_shipping_weight += $order_product->shipping_weight * $order_product->quantity;

                if($request->payment_status == 'Paid'){
                    $stock_note = 'Product order from admin panel.';
                    $stock_cost_amount = $order_product->sale_price;

                    // Stock History
                    StockRepo::hsitory('Subtraction', $order_product->product_id, $order_product->product_data_id, (0 - $order_product->quantity), $stock_cost_amount, $stock_note);

                    // // Update Stock
                    // StockRepo::stockSale($order_product->product_data_id, $order_product->quantity, $order_product->id);

                    // // Flash Quantities
                    // StockRepo::flashQuantities($order_product->product_data_id);
                }
            }
        }

        // Update total shipping weight
        $order->shipping_weight = $total_shipping_weight;
        $order->save();

        return redirect()->route('back.orders.show', $order->id)->with('success-alert', 'Order created successful.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $products = Product::active()->get();
        $courier_config = Info::SettingsGroupKey('courier');

        return view('back.orders.show', compact('order', 'products', 'courier_config'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'max:255',
            'mobile_number' => 'required|max:255',
            'address' => 'required|max:255',
            'quantity' => 'required'
        ]);

        if($request->status){
            $order->status = $request->status;
        }
        // $order->payment_method = $request->payment_method;
        if($request->payment_status){
            $order->payment_status = $request->payment_status;

            if($order->payment_status == $request->payment_status && $request->payment_status == 'Paid'){
                AccountsRepo::accounts('Credit', $order->grand_total, "Order Payment #$order->id");

                // Update Stock
                foreach($order->OrderProducts as $order_product){
                    $stock_note = 'Product order from admin panel.';
                    $stock_cost_amount = $order_product->sale_price;

                    // Stock History
                    StockRepo::hsitory('Subtraction', $order_product->product_id, $order_product->product_data_id, (0 - $order_product->quantity), $stock_cost_amount, $stock_note);

                    // // Update Stock
                    // StockRepo::stockSale($order_product->product_data_id, $order_product->quantity, $order_product->id);

                    // // Flash Quantities
                    // StockRepo::flashQuantities($order_product->product_data_id);
                }
            }
        }
        $order->note = $request->note;
        $order->staff_note = $request->staff_note;
        $order->discount_amount = $request->discount;
        $order->shipping_full_name = $request->name;
        $order->shipping_email = $request->email;
        $order->shipping_mobile_number = $request->mobile_number;
        $order->shipping_street = $request->address;

        // Attachment
        if ($request->file('attachment')){
            $file = $request->file('attachment');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/order';
            $file->move($destination, $file_name);
            $order->attachment = $file_name;
        }

        // Update Order Products
        $order_products_id = (array)$request->order_product;
        $order_products_quantity = (array)$request->quantity;
        $product_total = 0;
        foreach($order_products_id as $key => $order_product_id){
            $order_product = OrderProduct::find($order_product_id);
            $order_product->quantity = $order_products_quantity[$key];
            $order_product->save();

            $product_total += $order_product->sale_price * $order_product->quantity;
        }

        $order->product_total = $product_total;
        $order->shipping_charge = $request->shipping_charge ?? 0;
        $order->save();


        return redirect()->back()->with('success-alert', 'Order updated successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Add Item
    public function addItem(Request $request){
        $product = Product::find($request->product_id);

        if($product && $product->stock > 0){
            return view('back.orders.addItem', compact('product'))->render();
        }
        return 'false';
    }

    public function table(Request $request){
        $dollar_sign = Info::Settings('general', 'currency_symbol');

        // Get Data
        $columns = array(
            0 => 'id',
            1 => 'id',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = Order::query();

        // Status Filter
        if($request->status == 'CompletedTax'){
            $query->where('status', 'Completed')->where('tax_amount', '!=', 0);
        }elseif($request->status == 'PaidCoupon'){
            $query->where('payment_status', 'Paid')->where('coupon_code', '!=', null)->where('discount_amount', '!=', 0);
        }elseif($request->status != 'All'){
            $query->where('status', $request->status);
        }

        // Customer Filter
        if($request->customer){
            $query->where('user_id', $request->customer);
        }

        // Coupon Filter
        if($request->coupon_code){
            $query->where('coupon_code', $request->coupon_code);
        }

        // Date Filter
        if($request->from_date){
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if($request->to_date){
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if($request->id_range){
            $ids = explode('-', $request->id_range);

            if(isset($ids[0]) && $ids[0]){
                $query->where('id', '>=', $ids[0]);
            }
            if(isset($ids[1]) && $ids[1]){
                $query->where('id', '<=', $ids[1]);
            }
        }

        if(auth()->user()->type == 'order_employee'){
            $query->where('admin_id', auth()->user()->id);
        }

        // Search
        if($request->input('search.value')){
            $search = $request->input('search.value');
            $query->where(function($q) use ($search){
                $q->where('id', $search)
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('shipping_mobile_number', 'LIKE', "%{$search}%")
                ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                ->orWhere('street', 'LIKE', "%{$search}%");
            });
        }

        // Count Items
        $totalFiltered = $query->count();
        if($limit == "-1"){
            $query->skip($start)->limit($totalFiltered);
        }else{
            $query->skip($start)->limit($limit);
        }
        $query = $query->orderBy($order, $dir)->get();

        $output = array();
        foreach ($query as $key => $data) {
            $nestedData['sl'] = ($start + $key) + 1;
            if($dir == 'desc'){
                $nestedData['sl_desc'] = $totalFiltered - ($start + $key);
            }else{
                $nestedData['sl_desc'] = ($start + $key) + 1;
            }
            $nestedData['id'] = '<a href="'. route('back.orders.show', $data->id) .'">'. $data->id .'</a>';
            $nestedData['date'] = date('d/m/Y h:ia', strtotime($data->created_at));
            $nestedData['coupon_code'] = $data->coupon_code;
            $nestedData['select'] = '<input class="mt-1 checkbox_items" name="orders[]" type="checkbox" value="'. $data->id .'" style="width: 20px;height:20px">';
            $nestedData['order_name'] = $data->shipping_full_name ?? 'N/A';
            $nestedData['full_address'] = $data->shipping_full_address ?? 'N/A';
            // $nestedData['country'] = $data->full_name;
            $nestedData['mobile_number'] = $data->shipping_mobile_number ?? 'N/A';
            $nestedData['total_amount'] = $dollar_sign . number_format($data->grand_total, 2);
            $nestedData['discount_amount'] = $dollar_sign . number_format($data->discount_amount, 2);
            $nestedData['status'] = $data->status;
            $nestedData['tax_amount'] = $dollar_sign . number_format($data->tax_amount, 2);
            $nestedData['payment_status'] = $data->payment_status;
            $nestedData['action'] = '<div class="text-right"><a class="btn btn-success btn-sm" href="'. route('back.orders.show', $data->id) .'">Details</a></div>';
            $output[] = $nestedData;
        }

        // Output
        $output = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $output
        );
        return response()->json($output);
    }

    // Full Refund
    public function refund($id){
        $order_payment = OrderPayment::where('status', 'Active')->find($id);

        if(!$order_payment){
            return redirect()->back()->with('error-alert2', 'Payment is not active!');
        }

        $refund = mpgClasses::refund($order_payment);

        if($refund['success']){
            return redirect()->back()->with('success-alert2', 'Payment refunded successful.');
        }
        return redirect()->back()->with('error-alert2', 'Payment refund failed.');
    }

    public function returnRefund(Order $order){
        if($order->status == 'Returned' || $order->status == 'Partial'){
            return redirect()->route('back.orders.update', $order->id)->with('error-alert2', 'Your order already has return record!');
        }
        return view('back.orders.returnRefund', compact('order'));
    }
    public function returnRefundSubmit(Order $order, Request $request){
        if($order->status == 'Returned' || $order->status == 'Partial'){
            return redirect()->route('back.orders.update', $order->id)->with('error-alert2', 'Your order already has return record!');
        }

        if($request->refund_amount < 1){
            return redirect()->back()->with('error-alert2', 'Please insert some return quantity!');
        }

        $request->validate([
            'note' => 'required|max:255'
        ]);

        if($request->refund_payment){
            $order_payment = OrderPayment::find($request->refund_payment);

            $refund = mpgClasses::refund($order_payment, $request->refund_amount);

            if(!$refund['success']){
                return redirect()->back()->with('error-alert2', 'Payment refund failed!');
            }

            OrderRepo::payment($order->id, $request->refund_amount, $order_payment->gateway_order_id, $refund['tnx_number'], $request->note);
        }else{
            OrderRepo::payment($order->id, $request->refund_amount, null, null, $request->note);
        }

        // Insert expense
        AccountsRepo::expense($request->refund_amount, "Order payment refund #$order->id");
        AccountsRepo::accounts('Debit', $request->refund_amount, "Order payment refund #$order->id");

        if($request->total_quantity == $request->total_submitted_quantity){
            $status = 'Returned';
        }else{
            $status = 'Partial';
        }

        // $new_tax_amount = 0;
        foreach((array)$request->order_product as $key => $order_product){
            $order_product_query = OrderProduct::find($order_product);

            $order_product_query->return_quantity = $request->return_quantity[$key] ?? 0;
            $order_product_query->save();
            // $new_tax_amount += $order_product_query->calculated_tax_amount;

            // Stock History
            $stock_note = 'Stock added from order return.';
            $stock_cost_amount = $order_product_query->sale_price;
            StockRepo::hsitory('Addition', $order_product_query->product_id, $order_product_query->product_data_id, $order_product_query->return_quantity, $stock_cost_amount, $stock_note);

            // // Adjustment
            // $adjustment = new Adjustment();
            // $adjustment->total_amount = ($order_product_query->Product->cost ?? 0) * $order_product_query->return_quantity;
            // $adjustment->added_by = auth()->user()->full_name;
            // $adjustment->note = 'Stock added from order return.';
            // $adjustment->save();

            // $stock = new Stock;
            // $stock->adjustment_id = $adjustment->id;
            // $stock->product_id = $order_product_query->product_id;
            // $stock->product_data_id = $order_product_query->product_data_id;

            // $stock->purchase_quantity = $order_product_query->return_quantity;
            // $stock->current_quantity = $order_product_query->return_quantity;
            // $stock->purchase_price = $order_product_query->Product->cost ?? 0;

            // $stock->note = 'Stock added from order return.';
            // $stock->save();

            // // Flash Quantities
            // StockRepo::flashQuantities($stock->product_data_id);
        }

        $order->status = $status;
        $order->payment_status = 'Refunded';
        $order->refund_shipping_amount = $request->refund_shipping_amount;
        $order->refund_other_charge = $request->refund_other_charge;
        $order->refund_product_total = $request->refund_amount - ($request->refund_shipping_amount + $request->refund_other_charge);
        $order->refund_total_amount = $request->refund_amount;
        $order->tax_amount = $order->tax_amount - ($request->refund_tax ?? 0);
        $order->refund_tax_amount = $request->refund_tax ?? 0;
        $order->save();

        // Send mail to admin and customer
        $app_title = 'Sepalin Canada';
        Mail::to($order->email, $order->full_name)->bcc(env('ADMIN_NOTIFY_MAIL'))->send(new OrderRefundMail("Order Refunded #$order->id - $app_title", $order, $order->refund_total_amount));

        return redirect()->route('back.orders.update', $order->id)->with('success-alert2', 'Return submitted successful.');
    }

    public function eShipperLabel(Order $order){
        if($order->shipping_id && $order->shipping_order_id == null){
            $shipping = eShipperRepo::label($order);

            if($shipping['status']){
                $order->shipping_order_id = $shipping['data']['Order']['@attributes']['id'] ?? '';
                $order->save();

                return redirect()->back()->with('success', 'Shipping label created successful.');
            }
            return redirect()->back()->with('error', 'Something wrong!');
        }
        return redirect()->back()->with('error', 'Shipping label already created!');
    }

    public function selectCourier(Order $order){
        $shipping = eShipperRepo::create($order->shipping_street, $order->shipping_city, $order->shipping_state, $order->shipping_post_code, "", "", $order->shipping_weight);

        return view('back.orders.selectCourier', compact('order', 'shipping'));
    }

    public function selectCourierSubmit(Request $request, Order $order){
        if($order->shipping_id){
            return redirect()->route('back.orders.show', $order->id)->with('error', 'Courier already selected.');
        }

        $request->validate(['courier' => 'required']);
        $shipping = explode('::', $request->courier);

        $order->shipping_method = $shipping[0] ?? null;
        $order->hidden_shipping_charge = $shipping[1] ?? 0;
        $order->shipping_id = $shipping[2] ?? null;
        $order->save();

        return redirect()->route('back.orders.show', $order->id)->with('success', 'Courier selected successfully.');
    }

    public function addProduct(Request $request, $order_id){
        $request->validate([
            'product' => 'required'
        ]);

        $product = Product::find($request->product);

        OrderRepo::product($order_id, $request->product, $product->ProductData->id, $product->ProductData->custom_sale_price, 1);

        OrderRepo::index($order_id);

        return redirect()->back()->with('success', 'Product Added!');
    }

    public function exportCsv(){
        $orders = Order::get();

        return Excel::download(new OrderExport($orders), 'Orders'. date("Y-m-d-H-i-s") .'.csv');
    }

    public function printList(Request $request){
        $orders_id = (array)$request->orders;
        if(!count($orders_id)){
            return redirect()->back()->with('error', 'Please select some order!');
        }

        $orders = Order::whereIn('id', $orders_id);
        if(auth()->user()->type == 'order_employee'){
            $orders->where('admin_id', auth()->user()->id);
        }

        $orders = $orders->latest('id')->get();

        if($request->btn_type == 'steadfast_bulk'){
            return view('back.orders.courierBulkSubmission', compact('orders'));
        }elseif($request->btn_type == 'pathao_bulk'){
            return view('back.orders.courierBulkSubmission', compact('orders'));
        }elseif($request->btn_type == 'redx_bulk'){
            return view('back.orders.courierBulkSubmission', compact('orders'));
        }

        if($request->type == 'status_update'){
            if(!$request->status){
                return redirect()->back()->with('error', 'Please select an Status!');
            }

            Order::whereIn('id', $orders_id)->update([
                'status' => $request->status
            ]);

            return redirect()->back()->with('success', 'Orders status updated!');
        }

        return view('back.orders.printList', compact('orders'));
    }

    // https://api.hoorin.com/api/search/
    public function getSuccessRate(Request $request){
        $output = '';
        // if(env('APP_ENV') == 'local'){
        //     return $output;
        // }

        // // Pathao Status /// Do Not Remove /////////////////////////////////
        // $pathao_info = PathaoRepo::send(1055, 'POST', 'aladdin/api/v1/user/success', ['phone' => $request->mobile_number]);
        // if(isset($pathao_info['status']) && $pathao_info['status'] && ($pathao_info['response']['data']['customer'] ?? null)){
        //     $success_rate = ($pathao_info['response']['data']['success_rate'] ?? 0);
        //     $output .= '<h4 class="d-inline-block">Pathao</h4>
        //                 <span class="float-right"><b>Total:</b> '. ($pathao_info['response']['data']['customer']['total_delivery'] ?? 0) .', <b>Success:</b> '. ($pathao_info['response']['data']['customer']['successful_delivery'] ?? 0) .', <b>Failed:</b> '. (($pathao_info['response']['data']['customer']['total_delivery'] ?? 0) - ($pathao_info['response']['data']['customer']['successful_delivery'] ?? 0)) .'</span>
        //                 <div class="progress mb-3">
        //                     <div class="progress-bar '.($success_rate < 100 ? 'bg-danger' : 'bg-success').'" role="progressbar" style="width: '. $success_rate .'%;" aria-valuenow="'. $success_rate .'" aria-valuemin="0" aria-valuemax="100">'. $success_rate .'%</div>
        //                 </div>';
        // }

        $curl = curl_init();

        $post_field = 'searchTerm=' . $request->mobile_number;
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.hoorin.com/api/search/search_api.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post_field,
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $output_arr = json_decode($response, true);
        // return $output_arr;

        // Steadfast Status
        $steadfast_total = $output_arr['Steadfast API 1']['Total Parcels'] ?? 0;
        $steadfast_total_cancel = $output_arr['Steadfast API 1']['Total Canceled'] ?? 0;
        if(isset($output_arr['Steadfast API 2']['Total Parcels'])){
            $steadfast_total += $output_arr['Steadfast API 2']['Total Parcels'] ?? 0;
            $steadfast_total_cancel += $output_arr['Steadfast API 2']['Total Canceled'] ?? 0;
        }else{
            $sf_data = SteadFastRepo::successRate($request->mobile_number);

            if($sf_data['status']){
                $steadfast_total += $sf_data['total_delivery'];
                $steadfast_total_cancel += $sf_data['total_cancelled'];
            }
        }

        $steadfast_total_success = $steadfast_total - $steadfast_total_cancel;
        if($steadfast_total_success > 0 && $steadfast_total > 0){
            $steadfast_success_rate_percentage = round((($steadfast_total_success / $steadfast_total) * 100), 2);
        }else{
            $steadfast_success_rate_percentage = 0;
        }
        $output .= '<div class="row justify-content-center">';
        $output .= '<div class="col-md-2 text-center">
                        <div class="justify-content-center d-flex">
                            <div data-percent="'. $steadfast_success_rate_percentage .'" class="circles mb-1 mr-0 '.($steadfast_success_rate_percentage < 100 ? 'red' : '').'"></div>
                        </div>

                        <h5 class="mb-0">Steadfast</h5>
                        <p class="mb-0 circle_info"><small><b>Total:</b> '. $steadfast_total .'</small></p>
                        <p class="mb-0 circle_info""><small><b>Success:</b> '. $steadfast_total_success .'</small></p>
                        <p class="mb-0 circle_info"><small><b>Failed:</b> '. $steadfast_total_cancel .'</small></p>
                    </div>';
        // $output .= '<h4 class="d-inline-block">Steadfast</h4>
        //             <span class="float-right"><b>Total:</b> '. $steadfast_total .', <b>Success:</b> '. $steadfast_total_success .', <b>Failed:</b> '. ($steadfast_total_cancel) .'</span>
        //             <div class="progress mb-3">
        //                 <div class="progress-bar '.($steadfast_success_rate_percentage < 100 ? 'bg-danger' : 'bg-success').'" role="progressbar" style="width: '. $steadfast_success_rate_percentage .'%;" aria-valuenow="'. $steadfast_success_rate_percentage .'" aria-valuemin="0" aria-valuemax="100">'. $steadfast_success_rate_percentage .'%</div>
        //             </div>';

        // Pathao Status
        if(isset($output_arr['Pathao Result']['Total Delivery'])){
            $pathao_total = $output_arr['Pathao Result']['Total Delivery'] ?? 0;
            $pathao_total_success = $output_arr['Pathao Result']['Successful Delivery'] ?? 0;
            if($pathao_total_success > 0 && $pathao_total > 0){
                $pathao_success_rate_percentage = round((($pathao_total_success / $pathao_total) * 100), 2);
            }else{
                $pathao_success_rate_percentage = 0;
            }

            $output .= '<div class="col-md-2 text-center">
                            <div class="justify-content-center d-flex">
                                <div data-percent="'. $pathao_success_rate_percentage .'" class="circles mb-1 mr-0 '.($pathao_success_rate_percentage < 100 ? 'red' : '').'"></div>
                            </div>

                            <h5 class="mb-0">Pathao</h5>
                            <p class="mb-0 circle_info"><small><b>Total:</b> '. $pathao_total .'</small></p>
                            <p class="mb-0 circle_info""><small><b>Success:</b> '. $pathao_total_success .'</small></p>
                            <p class="mb-0 circle_info"><small><b>Failed:</b> '. ($pathao_total - $pathao_total_success) .'</small></p>
                        </div>';
            // $output .= '<h4 class="d-inline-block">Pathao</h4>
            //             <span class="float-right"><b>Total:</b> '. $pathao_total .', <b>Success:</b> '. $pathao_total_success .', <b>Failed:</b> '. ($pathao_total - $pathao_total_success) .'</span>
            //             <div class="progress mb-3">
            //                 <div class="progress-bar '.($pathao_success_rate_percentage <div 100 ? 'bg-danger' : 'bg-success').'" role="progressbar" style="width: '. $pathao_success_rate_percentage .'%;" aria-valuenow="'. $pathao_success_rate_percentage .'" aria-valuemin="0" aria-valuemax="100">'. $pathao_success_rate_percentage .'%</div>
            //             </div>';
        }else{
            $pathao_info = PathaoRepo::sendb('POST', 'aladdin/api/v1/user/success', ['phone' => $request->mobile_number]);
            if(isset($pathao_info['response']['type']) && $pathao_info['response']['type'] == 'success'){
                if(($pathao_info['response']['data']['customer']['total_delivery'] ?? 0) > 0){
                    $success_rate = $pathao_info['response']['data']['success_rate'] ?? 0;
                }else{
                    $success_rate = 0;
                }
                $output .= '<div class="col-md-2 text-center">
                                <div class="justify-content-center d-flex">
                                    <div data-percent="'. $success_rate .'" class="circles mb-1 mr-0 '.($success_rate < 100 ? 'red' : '').'"></div>
                                </div>

                                <h5 class="mb-0">Pathao</h5>
                                <p class="mb-0 circle_info"><small><b>Total:</b> '. ($pathao_info['response']['data']['customer']['total_delivery'] ?? 0) .'</small></p>
                                <p class="mb-0 circle_info""><small><b>Success:</b> '. ($pathao_info['response']['data']['customer']['successful_delivery'] ?? 0) .'</small></p>
                                <p class="mb-0 circle_info"><small><b>Failed:</b> '. (($pathao_info['response']['data']['customer']['total_delivery'] ?? 0) - ($pathao_info['response']['data']['customer']['successful_delivery'] ?? 0)) .'</small></p>
                            </div>';
                // $output .= '<h4 class="d-inline-block">Pathao</h4>
                //             <span class="float-right"><b>Total:</b> '. ($pathao_info['response']['data']['customer']['total_delivery'] ?? 0) .', <b>Success:</b> '. ($pathao_info['response']['data']['customer']['successful_delivery'] ?? 0) .', <b>Failed:</b> '. (($pathao_info['response']['data']['customer']['total_delivery'] ?? 0) - ($pathao_info['response']['data']['customer']['successful_delivery'] ?? 0)) .'</span>
                //             <div class="progress mb-3">
                //                 <div class="progress-bar '.($success_rate < 100 ? 'bg-danger' : 'bg-success').'" role="progressbar" style="width: '. $success_rate .'%;" aria-valuenow="'. $success_rate .'" aria-valuemin="0" aria-valuemax="100">'. $success_rate .'%</div>
                //             </div>';
            }
        }

        // REDx Status
        if(isset($output_arr['RedX Result']['Total Parcels'])){
            $redx_total = $output_arr['RedX Result']['Total Parcels'] ?? 0;
            $redx_total_success = $output_arr['RedX Result']['Delivered Parcels'] ?? 0;
            if($redx_total_success > 0 && $redx_total > 0){
                $redx_success_rate_percentage = round((($redx_total_success / $redx_total) * 100), 2);
            }else{
                $redx_success_rate_percentage = 0;
            }
            $output .= '<div class="col-md-2 text-center">
                                <div class="justify-content-center d-flex">
                                    <div data-percent="'. $redx_success_rate_percentage .'" class="circles mb-1 mr-0 '.($redx_success_rate_percentage < 100 ? 'red' : '').'"></div>
                                </div>

                                <h5 class="mb-0">REDx</h5>
                                <p class="mb-0 circle_info"><small><b>Total:</b> '. $redx_total .'</small></p>
                                <p class="mb-0 circle_info""><small><b>Success:</b> '. $redx_total_success .'</small></p>
                                <p class="mb-0 circle_info"><small><b>Failed:</b> '. ($redx_total - $redx_total_success) .'</small></p>
                            </div>';
        }else{
            $redx_data = RedxRepo::successRate($request->mobile_number);
            if($redx_data['status']){
                $redx_total = $redx_data['total_parcel'];
                $redx_total_success = $redx_data['success_parcel'];

                if($redx_total_success > 0 && $redx_total > 0){
                    $redx_success_rate_percentage = round((($redx_total_success / $redx_total) * 100), 2);
                }else{
                    $redx_success_rate_percentage = 0;
                }
                $output .= '<div class="col-md-2 text-center">
                                    <div class="justify-content-center d-flex">
                                        <div data-percent="'. $redx_success_rate_percentage .'" class="circles mb-1 mr-0 '.($redx_success_rate_percentage < 100 ? 'red' : '').'"></div>
                                    </div>

                                    <h5 class="mb-0">REDx</h5>
                                    <p class="mb-0 circle_info"><small><b>Total:</b> '. $redx_total .'</small></p>
                                    <p class="mb-0 circle_info""><small><b>Success:</b> '. $redx_total_success .'</small></p>
                                    <p class="mb-0 circle_info"><small><b>Failed:</b> '. ($redx_total - $redx_total_success) .'</small></p>
                                </div>';
            }
        }

        $paperfly_data = PaperflyRepo::successRate($request->mobile_number);
        if($paperfly_data['status']){
            $paperfly_total = $paperfly_data['total'];
            $paperfly_total_success = $paperfly_data['delivered'];

            if($paperfly_total_success > 0 && $paperfly_total > 0){
                $paperfly_success_rate_percentage = round((($paperfly_total_success / $paperfly_total) * 100), 2);
            }else{
                $paperfly_success_rate_percentage = 0;
            }
            $output .= '<div class="col-md-2 text-center">
                            <div class="justify-content-center d-flex">
                                <div data-percent="'. $paperfly_success_rate_percentage .'" class="circles mb-1 mr-0 '.($paperfly_success_rate_percentage < 100 ? 'red' : '').'"></div>
                            </div>

                            <h5 class="mb-0">Paperfly</h5>
                            <p class="mb-0 circle_info"><small><b>Total:</b> '. $paperfly_total .'</small></p>
                            <p class="mb-0 circle_info""><small><b>Success:</b> '. $paperfly_total_success .'</small></p>
                            <p class="mb-0 circle_info"><small><b>Failed:</b> '. ($paperfly_total - $paperfly_total_success) .'</small></p>
                        </div>';
        }

        $output .= '</div>';
        // $output .= '<h4 class="d-inline-block">REDx</h4>
        //             <span class="float-right"><b>Total:</b> '. $redx_total .', <b>Success:</b> '. $redx_total_success .', <b>Failed:</b> '. ($redx_total - $redx_total_success) .'</span>
        //             <div class="progress mb-3">
        //                 <div class="progress-bar '.($redx_success_rate_percentage < 100 ? 'bg-danger' : 'bg-success').'" role="progressbar" style="width: '. $redx_success_rate_percentage .'%;" aria-valuenow="'. $redx_success_rate_percentage .'" aria-valuemin="0" aria-valuemax="100">'. $redx_success_rate_percentage .'%</div>
        //             </div>';

        $output .= '<script>$(".circles").percircle();</script>';
        return $output;
    }
}
