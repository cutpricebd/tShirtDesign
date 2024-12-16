<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirm;
use App\Models\Order\Order;
use App\Models\User;
use App\Repositories\AccountsRepo;
use App\Repositories\CartRepo;
use App\Repositories\eShipperRepo;
use App\Repositories\FBConversionRepo;
use App\Repositories\OrderRepo;
use App\Repositories\StockRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Stripe;
class OrderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->middleware('auth');
    }

    public function checkout(){
        // Refresh
        CartRepo::refresh();

        $carts = CartRepo::summary();

        return view('front.checkout', compact('carts'));
    }

    public function order(Request $request){
        $v_data = [
            'name' => 'required|max:255',
            'mobile_number' => 'required|max:25',
            //'address' => 'required|max:255',
            //'note' => 'max:2555',
            'email' => 'required|email|max:255',
            'province' => 'required|max:255',
            'postal_code' => 'required|max:255',
            'city' => 'required|max:255',
            'street' => 'required|max:255',
            'country' => 'required|max:255',
        ];
        $request->validate($v_data);
        //dd($request);


        // Refresh
        CartRepo::refresh();
        // Carts
        $cart_summary = CartRepo::summary($request->shipping_charge ?? 0);
        $carts = CartRepo::get();

        if(!count($carts)){
            return redirect()->route('cart')->with('error-alert', 'Your cart is empty!');
        }

        // Client
        if(auth()->user()){
            $client = auth()->user();
        }else{
            $client = User::where('mobile_number', $request->mobile_number)->first();
            if(!isset($client->id) && $request->email){
                $client = User::where('email', $request->email)->first();
            }
            if(!isset($client->id)){
                $client = new User;
                $client->last_name = $request->name;
                $client->mobile_number = $request->mobile_number;
                $client->email = $request->email;
                $client->street = $request->address;
                $client->password = Hash::make(123456789);
                $client->save();
            }
        }

        // $admin = User::where('type', 'order_employee')->first();
        // if(!$admin){
        // }
        $admin = User::where('type', 'order_employee')->orderBy('order_submitted_at')->first();

        $order = new Order();

        $order->admin_id = $admin->id ?? null;

        // Customer Information
        $order->user_id = $client->id;
        $order->last_name = $request->name;
        $order->street = $request->address;
        $order->mobile_number = $request->mobile_number;
        $order->email = $request->email;
        $order->note = $request->note;

        // Customer Shipping Information
        $order->shipping_full_name = $request->name;
        $order->shipping_email = $request->email;
        $order->shipping_mobile_number = $request->mobile_number;
        $order->shipping_street = $request->address;

        // Charges
        $order->product_total = $cart_summary['product_total'];
        $order->tax_amount = $cart_summary['tax_amount'] ?? 0;
        $order->discount = $cart_summary['only_discount'];
        $order->discount_amount = $cart_summary['discount'];

        // Shipping
        $order->shipping_charge = $request->shipping_charge??0;
        $order->shipping_method = '';
        $order->shipping_weight = 0;
        // $order->shipping_id = $request->shipping_service_id;

        // // Coupon
        // $coupon_code = Cookie::get('coupon');
        // if($coupon_code){
        //     $coupon = Coupon::where('code', $coupon_code)->first();

        //     $order->coupon_id = $coupon->id;
        //     $order->coupon_code = $coupon_code;

        //     Cookie::queue('coupon', null, 1);

        //     // Update coupon
        //     $coupon->total_use += 1;
        //     $coupon->save();
        // }

        $order->save();

        if($admin){
            $admin->order_submitted_at = Carbon::now();
            $admin->save();
        }

        // Insert Order Status
        OrderRepo::status($order->id, 'Order created', 'Customer');

        // Insert order products
        $order_items = array();
        foreach($carts as $key => $cart){
            $order_product = OrderRepo::product($order->id, $cart->product_id, $cart->product_data_id, $cart->ProductData->custom_sale_price, $cart->quantity);

            $order_items[$key]['title'] = $order_product->Product->title ?? 'n/a';
            $order_items[$key]['price'] = $order_product->sale_price;
            $order_items[$key]['quantity'] = $order_product->quantity;
            $order_items[$key]['image'] = $order_product->Product->img_paths['original'] ?? asset('img/default-img.png');
            $order_items[$key]['attributes'] = $cart->ProductData->attribute_items_string ?? null;
        }

        if(env('COMMON_ORDER')){
            $body_data['name'] = $order->shipping_full_name;
            $body_data['sales_partner'] = env('APP_NAME');
            $body_data['address'] = $order->shipping_street;
            $body_data['mobile_number'] = $order->shipping_mobile_number;
            $body_data['payment_method'] = 'cod';
            $body_data['shipping_charge'] = $order->shipping_charge;

            $body_data['order_items'] = $order_items;
            $response = Http::post(env('COMMON_ORDER_API_URL'), $body_data);
        }

        // Delete Cart
        $session_id = Session::getId();
        if(auth()->check()){
            DB::table('carts')->where('user_id', auth()->user()->id)->delete();
        }else{
            DB::table('carts')->where('session_id', $session_id)->delete();
        }

        return redirect()->route('orderComDetails', $order->id)->with('success-alert', 'Order created success.');
    }

    public function orderComDetails($id)
    {
        $order = Order::with('OrderProducts')->find($id);
        if (!isset($order->id)) return view('front.not-found-page');

        $track = true;
        try{
            if($order->order_tracked == 0){
                $order->order_tracked = 1;
                $order->save();
            }else{
                $track = false;
            }
        }catch(\Exception $e){}

        $products = array();
        $content_ids = array();
        foreach($order->OrderProducts as $i => $product){
            $products[] = [
                'id' => $product->product_id,
                'quantity' => $product->quantity
            ];
            $content_ids[] = $product->product_id;
        }
        // if(env('FB_CONVERSION_TRACK')){

        //     $data = [
        //         'value' => $order->grand_total,
        //         'currency' => 'BDT',
        //         'contents' => $products,
        //         'content_ids' => $content_ids,
        //     ];
        //     $test = FBConversionRepo::track('Purchase', $data, hash('sha256', $order->mobile_number));
        // }

        return view('front.orderComDetails', compact('order', 'products', 'content_ids', 'track'));
    }

    public function paymentSubmitStripe(Request $request, $id){
        $order = Order::whereIn('payment_status', ['Pending', 'Due'])->find($id);
        if(!isset($order->id)){
            return redirect()->route('homepage')->with('error-alert2', 'Order payment already done!');
        }
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = Stripe\Charge::create ([
            "amount" => (int)($order->grand_total * 100),
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Order Payment"
        ]);

        if($stripe->status == 'succeeded'){
            $order->payment_status = 'Paid';
            $order->payment_method = 'Stripe';
            $order->save();

            OrderRepo::paid($order->id);

            AccountsRepo::accounts('Credit', $order->grand_total, "Order Payment #$order->id");

            // Send mail to admin and customer
            $app_title = env('APP_NAME');
            try {
                Mail::to($order->email, $order->full_name)->bcc(env('ADMIN_NOTIFY_MAIL'))
                    ->send(new OrderConfirm("New Order #$order->id - $app_title", $order, false));

            }catch (\Exception $e){
                //
            }
            // Update Stock
            foreach($order->OrderProducts as $order_product){
                // Update Stock
                StockRepo::stockSale($order_product->product_data_id, $order_product->quantity, $order_product->id);

                // Flash Quantities
                StockRepo::flashQuantities($order_product->product_data_id);
            }

            return redirect()->route('orders.complected', $order->id)->with('success-alert2', 'Order payment successful.');
        }
        return redirect()->route('orders.complected', $order->id)->with('error-alert2', 'Order payment failed.');
    }

    public function orderSuccess($id){
        $order = Order::find($id);
        if (!isset($order->id)) return view('front.not-found-page');

        $products = array();
        $content_ids = array();
        foreach($order->OrderProducts as $i => $product){
            $products[] = [
                'id' => $product->product_id,
                'quantity' => $product->quantity
            ];
            $content_ids[] = $product->product_id;
        }

        return view('front.order.complete', compact('order', 'products', 'content_ids'));
    }

    public function getShipping(Request $request){
        //$shipping_charge = OrderRepo::getShippingCharge($request->province, $request->country, $request->city);
        $cart_summary = CartRepo::summary();

        // Shipping Request
        $shipping = eShipperRepo::create($request->address, $request->city, $request->province, $request->post_code, "", "", $cart_summary['n_shipping_weight']);

        $product_total = $cart_summary['product_total'];
        return view('front.order.getShipping', compact('shipping', 'product_total'));
    }
    public function getShippingManual(Request $request){
        $shipping_charge = OrderRepo::getShippingCharge($request->province, $request->country, $request->city);
        $cart_summary = CartRepo::summary($shipping_charge);
        return response()->json($cart_summary,200);
    }

    public function getShippingInfo(Request $request){
        $si_arr = explode('::', $request->shipping_courier);

        $cart_summary = CartRepo::summary(($si_arr[1] ?? ''), ($si_arr[0] ?? 0), ($si_arr[2] ?? ''), ($si_arr[3] ?? ''));

        return $cart_summary;
    }

}
