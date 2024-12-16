<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\ClientPhone;
use App\Models\ImageReview;
use App\Models\Landing;
use App\Models\LandingBuilder;
use App\Models\Order\Order;
use App\Models\PaymentHistory;
use App\Models\Product\Product;
use App\Models\ProductCatRel;
use App\Models\ProductMeta;
use App\Models\PushSubscribe;
use App\Models\Review;
use App\Models\SalesPartner;
use App\Models\State;
use App\Models\User;
use App\Repositories\FBTrackingRepo;
use App\Repositories\JsonResponse;
use App\Repositories\OrderRepo;
use App\Repositories\SMSRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LandingController extends Controller
{
    public function index(){
        $product_2 = null;
        $products = [];
        if(request()->getHost() == 'jacket.cutpricebd.com' || request()->getHost() == 'jacket.jacketbd.com'){
            $product = Product::findOrFail(391);
            $product_ids = [391];
        }elseif(request()->getHost() == 'latherjacket.cutpricebd.com' || request()->getHost() == 'latherjacket.jacketbd.com'){
            $product = Product::findOrFail(377);
            $product_2 = Product::findOrFail(785);
            $product_ids = [377, 785];

            $products = Product::whereIn('id', [377, 391, 785, 24325, 63022, 62995, 62990])->orderBy('position')->get();
            // $product = Product::findOrFail(62995);
            // $product_ids = [62995];
        }elseif(request()->getHost() == 'teddybearbd.com' || request()->getHost() == 'valentinegift.teddybearbd.com'){
            $product = Product::findOrFail(93690);
            $product_ids = [93690];

            $products = Product::whereIn('id', [93689, 64369, 93688, 93690, 93691, 93692])->orderBy('position')->get();
            // $product = Product::findOrFail(62995);
            // $product_ids = [62995];
        }elseif(request()->getHost() == 'ladies.jacketbd.com'){
            $product = Product::findOrFail(94809);
            $product_ids = [94809];

            $products = Product::whereIn('id', [94809, 94808, 94807, 94806, 94805, 94804, 94803])->orderBy('position')->get();
        }elseif(request()->getHost() == 'nicotex.cutpricebd.com' || request()->getHost() == 'nicotex.jacketbd.com'){
            $product = Product::findOrFail(64906);
            $product_ids = [64906];

            $products = Product::whereIn('id', [64906, 64917])->orderBy('position')->get();
            // $product = Product::findOrFail(62995);
            // $product_ids = [62995];
        }elseif(request()->getHost() == 'chiaseed.cutpricebd.com' || request()->getHost() == 'chiaseed.jacketbd.com'){
            $product = Product::findOrFail(77456);
            $product_2 = null;
            $product_ids = [77456];

            $products = Product::whereIn('id', [77456])->get();
            // $product = Product::findOrFail(62995);
            // $product_ids = [62995];
        }elseif(request()->getHost() == 'sahiseed.mushroomshopbd.com'){
            $product = Product::findOrFail(77456);
            $product_2 = null;
            $product_ids = [77456];

            $products = Product::whereIn('id', [77456])->get();
            // $product = Product::findOrFail(62995);
            // $product_ids = [62995];
        }elseif(request()->getHost() == 'teen.mushroomshopbd.com'){
            $product = Product::findOrFail(77456);
            $product_2 = null;
            $product_ids = [77456];

            $products = Product::whereIn('id', [77456])->get();
        }elseif(request()->getHost() == 'akhrot.mushroomshopbd.com'){
            $product = Product::findOrFail(77456);
            $product_2 = null;
            $product_ids = [77456];

            $products = Product::whereIn('id', [77456])->get();
        }elseif(request()->getHost() == 'mushroom.mushroomshopbd.com'){
            $product = Product::findOrFail(77456);
            $product_2 = null;
            $product_ids = [77456];

            $products = Product::whereIn('id', [77456])->get();
        }elseif(request()->getHost() == 'omega.mushroomshopbd.com'){
            $product = Product::findOrFail(87193);
            $product_2 = null;
            $product_ids = [87193];

            $products = Product::whereIn('id', [87239])->get();
        }elseif(request()->getHost() == 'hoddy.cutpricebd.com' || request()->getHost() == 'hoddy.jacketbd.com'){
            $product = Product::findOrFail(38458);
            $product_2 = Product::findOrFail(64723);
            $product_ids = [38458, 64723];

            $products = Product::whereIn('id', [38458])->orderBy('position')->get();
        }elseif(request()->getHost() == 'hoddy2.cutpricebd.com' || request()->getHost() == 'hoddy2.jacketbd.com'){
            $product = Product::findOrFail(38458);
            $product_2 = Product::findOrFail(64723);
            $product_ids = [38458, 64723];
        }elseif(request()->getHost() == 'bonetech.cutpricebd.com'){
            $product = Product::findOrFail(62995);
            $product_ids = [62995];
        }elseif(request()->getHost() == 'koreanredginseng.shop'){
            $landing = Landing::where('url', 'koreanredginseng.shop')->first();
            $product = Product::findOrFail($landing->product_ids);
            $product_ids = [$landing->product_ids];

            $products = Product::whereIn('id', [$landing->product_ids])->get();
        }elseif((request()->getHost() == 'stylishjacket.cutpricebd.com' || request()->getHost() == 'stylishjacket.jacketbd.com') || request()->getHost() == 'jacketbd.com'){
            $product = Product::findOrFail(377);
            $product_2 = Product::findOrFail(785);
            $product_ids = [377, 785];

            $products = Product::whereIn('id', [377, 391, 785, 24325, 63022, 62995, 62990])->orderBy('position')->get();
            // $product = Product::findOrFail(62995);
            // $product_ids = [62995];
        }else{
            abort(404);
        }
        $reviews = Review::whereIn('product_id', $product_ids)->where('status', 'Approved')->latest('created_at')->get();

        $category_ids = ProductCatRel::whereIn('product', $product_ids)->pluck('category');
        $related_products = ProductCatRel::with('Product')
        ->join('products', 'products.id', 'product_cat_rels.product')
        ->where('products.status', 1)
        ->whereNotIn('products.id', $product_ids)
        ->whereIn('product_cat_rels.category', $category_ids)
        ->select('product_cat_rels.product', 'products.position')
        ->distinct()->orderBy('products.position')->take(40)->get()->pluck('Product');

        if($product->type == 'variable' && $product_2 && $product_2->type == 'general'){
            $metas_1_id = ProductMeta::where('type', 'variation')->whereIn('product_id', $product_ids)->pluck('id')->toArray();
            $metas_2_id = ProductMeta::where('type', 'general')->where('product_id', $product_2->id)->pluck('id')->toArray();

            $metas = ProductMeta::where(function($q)use($metas_1_id, $metas_2_id){
                $q->whereIn('id', $metas_1_id)->orWhereIn('id', $metas_2_id);
            })->get();
        }elseif($product->type == 'variable'){
            $metas = ProductMeta::where('type', 'variation')->whereIn('product_id', $product_ids)->get();
        }else{
            $metas = ProductMeta::where('type', $product->type)->where('product_id', $product->id)->first();
        }

        $states = cache()->remember('get_states', (60 * 60 * 24 * 90), function(){
            $json = json_decode(file_get_contents('https://oms.cutpricebd.com/api/v2/get-states'), true);
            if(isset($json['data'])){
                return $json['data'];
            }
            return [];
        });

        $image_reviews = ImageReview::whereIn('product_id', $product_ids)->latest('id')->get();

        if(request()->getHost() == 'jacket.cutpricebd.com' || request()->getHost() == 'jacket.jacketbd.com'){
            return view('landing.jacket', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'hoddy.cutpricebd.com' || request()->getHost() == 'hoddy.jacketbd.com'){
            return view('landing.hoddy', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'hoddy2.cutpricebd.com' || request()->getHost() == 'hoddy2.jacketbd.com'){
            return view('landing2.hoddy', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'latherjacket.cutpricebd.com' || request()->getHost() == 'latherjacket.jacketbd.com'){
            // return view('landing.latherJacket', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2'));
            return view('landing.stylishjacket', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif((request()->getHost() == 'stylishjacket.cutpricebd.com' || request()->getHost() == 'stylishjacket.jacketbd.com') || request()->getHost() == 'jacketbd.com'){
            return view('landing.stylishjacket', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'koreanredginseng.shop'){
            return view('landing.editableLanding', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products', 'landing'));
        }elseif(request()->getHost() == 'chiaseed.cutpricebd.com' || request()->getHost() == 'chiaseed.jacketbd.com'){
            return view('landing3.chia-seed', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'teddybearbd.com' || request()->getHost() == 'valentinegift.teddybearbd.com'){
            return view('landing3.doll2', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'nicotex.cutpricebd.com' || request()->getHost() == 'nicotex.jacketbd.com'){
            return view('landing3.nicotex', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'bonetech.cutpricebd.com' || request()->getHost() == 'bonetech.jacketbd.com'){
            return view('landing.bonetech', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'ladies.jacketbd.com'){
            return view('landing3.ladies', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'sahiseed.mushroomshopbd.com'){
            return view('landing3.sahiSeed', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'teen.mushroomshopbd.com'){
            return view('landing3.teen', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'akhrot.mushroomshopbd.com'){
            return view('landing3.akhrot', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'mushroom.mushroomshopbd.com'){
            return view('landing3.mushroom', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }elseif(request()->getHost() == 'omega.mushroomshopbd.com'){
            return view('landing3.omega', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
        }else{
            abort(404);
        }
    }

    public function latherJacket(){
        $product = Product::findOrFail(377);
        $product_2 = Product::findOrFail(785);
        $product_ids = [377, 785];

        $products = Product::whereIn('id', [377, 391, 785, 24325, 63022, 62995, 62990])->orderBy('position')->get();

        $reviews = Review::whereIn('product_id', $product_ids)->where('status', 'Approved')->latest('created_at')->get();

        $category_ids = ProductCatRel::whereIn('product', $product_ids)->pluck('category');
        $related_products = ProductCatRel::with('Product')
        ->join('products', 'products.id', 'product_cat_rels.product')
        ->where('products.status', 1)
        ->whereNotIn('products.id', $product_ids)
        ->whereIn('product_cat_rels.category', $category_ids)
        ->select('product_cat_rels.product', 'products.position')
        ->distinct()->orderBy('products.position')->take(40)->get()->pluck('Product');

        if($product->type == 'variable' && $product_2 && $product_2->type == 'general'){
            $metas_1_id = ProductMeta::where('type', 'variation')->whereIn('product_id', $product_ids)->pluck('id')->toArray();
            $metas_2_id = ProductMeta::where('type', 'general')->where('product_id', $product_2->id)->pluck('id')->toArray();

            $metas = ProductMeta::where(function($q)use($metas_1_id, $metas_2_id){
                $q->whereIn('id', $metas_1_id)->orWhereIn('id', $metas_2_id);
            })->get();
        }elseif($product->type == 'variable'){
            $metas = ProductMeta::where('type', 'variation')->whereIn('product_id', $product_ids)->get();
        }else{
            $metas = ProductMeta::where('type', $product->type)->where('product_id', $product->id)->get();
        }

        $states = cache()->remember('get_states', (60 * 60 * 24 * 90), function(){
            $json = json_decode(file_get_contents('https://oms.cutpricebd.com/api/v2/get-states'), true);
            if(isset($json['data'])){
                return $json['data'];
            }
            return [];
        });
        $image_reviews = ImageReview::whereIn('product_id', $product_ids)->latest('id')->get();

        return view('landing3.omega', compact('product', 'reviews', 'related_products', 'metas', 'states', 'image_reviews', 'product_2', 'products'));
    }

    public function order($product_id, Request $request){
        // if(env('CONVERSIONS_API_TRACK')){
        //     $fb_track_data = array();
        //     $fb_track_data['event_type'] = 'InitiateCheckout';
        //     $fb_track_data['event_time'] = time();
        //     $fb_track_data['custom_data'] = array();
        //     FBTrackingRepo::track('sfdsf', '6058808420796594', $fb_track_data);
        // }

        $request->validate([
            'name' => 'required|max:191',
            'mobile_number' => 'required|max:191',
            'address' => 'required|max:191',
            'state' => 'required',
            'shipping_charge' => 'required'
        ]);
        $user = null;

        $phone = new ClientPhone();
        $phone->setConnection(env('CP_DB_CONNECTION') ?? 'mysql');
        $phone = $phone->where('phone_no', $request->mobile_number)->first();

        if($phone){
            $user = new User;
            $user->setConnection(env('CP_DB_CONNECTION') ?? 'mysql');
            $user = $user->where('id', $phone->user_id)->first();
        }

        // State
        $state = State::where('name', $request->state)->first();

        // Insert User
        if(!$user){
            $user = new User;
            $user->setConnection(env('CP_DB_CONNECTION') ?? 'mysql');
            $user->name = $request->name;
            $user->mobile = $request->mobile_number;
            if ($request->email) {
                $user->email = $request->email;
            }
            $user->address = $request->address ?? ($state->name ?? 'n/a');
            $user->total_order = 1;

            if($state){
                $user->state_id = $state->id;
            }
            if($request->city){
                $user->city_id = $request->city;
            }

            $user->country_id = env('APP_DEFAULT_COUNTRY');
            $user->password = Hash::make($request->password);
            $user->api_token = Hash::make(date('Y-m-d H:i:s') . $request->mobile_number);
            if ($user->save()) {
                // Save Mobile Number
                DB::connection(env('CP_DB_CONNECTION') ?? 'mysql')->table('client_phones')->insert(['phone_no' => $request->mobile_number, 'user_id' => $user->id, 'phone_code' => $user->Country->phonecode]);
            }
        }

        // Get SP
        $sp = new SalesPartner();
        $sp->setConnection(env('CP_DB_CONNECTION') ?? 'mysql');
        $sp = $sp->where('name', 'Website Order')->first();

        if(!$sp){
            $sp = new SalesPartner;
            $sp->setConnection(env('CP_DB_CONNECTION') ?? 'mysql');
            $sp->name = 'Website Order';
            $sp->save();
        }

        // Insert Order
        $order = new Order();
        $order->setConnection(env('CP_DB_CONNECTION') ?? 'mysql');
        $order->user_id = $user->id;
        $order->website = env('APP_WEBSITE') ?? null;
        $order->status = 'pending';
        $order->order_name = $request->name;
        $order->sales_partner_id = $sp->id;
        $order->shipping_cost = $request->shipping_charge;
        if ($request->note) {
            $order->note = $request->note;
        }
        $order->shipping_address = $request->address ?? ($state->name ?? 'n/a');
        $order->country_id = 19;
        $order->phone = $request->mobile_number;
        $order->state_id = $state->id;

        if($request->city){
            $order->city_id = $request->city;
        }
        $order->city_id = $request->city ?? null;
        $order->zip = $request->post_code ?? null;
        $order->tax = $request->tax ?? 0;
        $order->pay_method = 'cod';

        $order->product_total = 0;

        if ($order->save()){
            $products_id = (array)$request->product_id;
            $quantity = (array)$request->quantity;
            $metas = (array)$request->meta;
            $variations = (array)$request->variation;

            $productTotal = 0;
            foreach($products_id as $key => $product_id){
                $product = Product::find($product_id);

                $meta = null;
                if($metas[$key]){
                    $meta = ProductMeta::find($metas[$key]);
                }elseif($variations[$key] && $variations[$key] != '.'){
                    $ids = explode('.', $variations[$key]);
                    asort($ids);

                    $string = '';
                    foreach($ids as $id){
                        if($id){
                            $string .= $id . '.';
                        }
                    }
                    $meta = ProductMeta::where('product_id', $product_id)->where('attribute_value_ids', $string)->where('type', 'variation')->first();
                }

                if(!$meta){
                    if ($product->type == 'variable'){
                        $meta = $product->variableMeta[0];;
                    }else{
                        $meta = $product->single_meta;
                    }
                }

                $orderProduct = new OrderProduct();
                $orderProduct->setConnection(env('CP_DB_CONNECTION') ?? 'mysql');
                $orderProduct->website = env('APP_WEBSITE') ?? null;
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $product_id;
                $orderProduct->product_meta_id = $meta->id;
                $orderProduct->quantity = $quantity[$key] ?? 1;
                $orderProduct->selling_price = $meta->selling_price;

                $orderProduct->product_title = $product->name ?? null;
                $orderProduct->product_image = $product->others_arr->default_image ?? null;

                $orderProduct->save();

                $productTotal += $meta->selling_price * $orderProduct->quantity;
            }
        }

        // Update Order Product Total
        $order->product_total = $productTotal;

        $order->save();

        if($request->payment_number){
            $payment = new PaymentHistory;
            $payment->status = 2;
            $payment->order_id = $order->id;
            $payment->amount = $request->shipping_charge;
            $payment->payment_method = 'bkash';
            $payment->added_by = 'Customer';
            $payment->save();
        }

        // Save Status
        OrderRepo::status($order->id, "Order created from customer", 'customer');

        // Order Index
        OrderRepo::index($order->id);

        // Send Order SMS
        if (web('sms', 'smsStatus')){
            $parameter = [
                "{name}" => $order->name,
                "{order_id}" => $order->id,
                "{web_url}" => web('General Settings', 'web_url')
            ];
            $smsBody = SMSTemplate('New Order', $parameter);
            if($smsBody){
                $phoneCode = $user->country ? $user->country->phonecode : 880;
                SMSRepo::send($smsBody, $request->mobile_number, $order->id, $phoneCode);
            }
        }

        // if(env('CONVERSIONS_API_TRACK')){
        //     $fb_track_data = array();
        //     $fb_track_data['event_type'] = 'Purchase';
        //     $fb_track_data['event_time'] = time();
        //     $fb_track_data['custom_data'] = array();

        //     $data['custom_data']['value'] = $order->order_total / 106.09;
        //     $data['custom_data']['currency'] = 'USD';
        //     $data['custom_data']['content_name'] = $product->name;
        //     $data['custom_data']['content_type'] = 'product';
        //     $data['custom_data']['content_ids'] = '['. $product->id .']';

        //     FBTrackingRepo::track('sfdsf', '6058808420796594', $fb_track_data);
        // }

        return redirect()->route('landing.orderSuccess', $order->id);
    }

    public function landingBuilderOrder($landing_id, Request $request){
        // try{
            $landing = LandingBuilder::find($landing_id);
            $products = Product::whereIn('id', $landing->products_id)->get();
            if(!count($products)){
                return view('front.not-found-page');
            }

            // if(env('CONVERSIONS_API_TRACK')){
            //     $fb_track_data = array();
            //     $fb_track_data['event_type'] = 'InitiateCheckout';
            //     $fb_track_data['event_time'] = time();
            //     $fb_track_data['custom_data'] = array();
            //     FBTrackingRepo::track('sfdsf', '6058808420796594', $fb_track_data);
            // }

            $request->validate([
                'name' => 'required|max:191',
                'mobile_number' => 'required|max:191',
                'address' => 'required|max:191',
                'state' => 'required',
                'shipping_charge' => 'required'
            ]);
            $user = null;
            $user = User::where('mobile_number', $request->mobile_number)->first();
            if(!$user && $request->email){
                $user = User::where('email', $request->email)->first();
            }
            if(!$user){
                $user = new User;
                $user->last_name = $request->name;
                $user->mobile_number = $request->mobile_number;
                $user->email = $request->email;
                $user->street = $request->address;
                $user->password = Hash::make(123456789);
                $user->save();
            }

            $admin = User::where('type', 'order_employee')->orderBy('order_submitted_at')->first();

            $order = new Order();

        $order->admin_id = $admin->id ?? null;

        // Customer Information
        $order->user_id = $user->id;
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
        $order->product_total = 0;
        $order->tax_amount = 0;
        $order->discount = 0;
        $order->discount_amount = 0;

        // Shipping
        $order->shipping_charge = $request->shipping_charge;
        $order->shipping_method = 'Cash On delivery';
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

        $product_total = 0;
        foreach($products as $product){
            if($product->ProductData){
                $order_product = OrderRepo::product($order->id, $product->id, $product->ProductData->id, $product->ProductData->custom_sale_price, 1);
                $product_total += $product->ProductData->custom_sale_price;
            }
        }
        $order->product_total = $product_total;
        $order->save();
        // }catch(\Exception $e){
        //     abort(404);
        // }

        return redirect()->route('landing.orderSuccessB', ['id' => $order->id, 'landing' => $landing->id]);
    }

    public function orderSuccess($id){
        $order = Order::find($id);
        if (!isset($order->id)) return view('front.not-found-page');

        $products = array();
        $content_ids = array();
        foreach($order->order_products as $i => $product){
            $products[] = [
                'id' => $product->product_id,
                'quantity' => $product->quantity
            ];
            $content_ids[] = $product->product_id;
        }

        return view('landing.orderSuccess', compact('order', 'products', 'content_ids'));
    }

    public function orderSuccessB($id, $landing){
        $order = Order::find($id);
        $landing = LandingBuilder::find($landing);

        if (!isset($order->id) || !isset($landing->id)) return view('front.not-found-page');

        $products = array();
        $content_ids = array();
        foreach($order->OrderProducts as $i => $product){
            $products[] = [
                'id' => $product->product_id,
                'quantity' => $product->quantity
            ];
            $content_ids[] = $product->product_id;
        }

        return view('landing.orderSuccessB', compact('order', 'products', 'content_ids', 'landing'));
    }

    public function pushSubscribe(Request $request){
        $check = PushSubscribe::query();
        $check->where('relation_with', $request->website);
        $check = $check->where('token', $request->token)->first();

        if (!$check){
            $query = new PushSubscribe();
            $query->relation_with = $request->website;
            $query->token = $request->token;
            $query->save();
        }

        return JsonResponse::onlyMessage('Notification Subscribed!');
    }

    public function getCities(Request $request){
        $state = State::where('name', $request->state)->first();
        $cities = City::where('state_id', ($state->id ?? null))->get();

        $output = '<option value="">আপনার শহর সিলেক্ট করুন</option>';
        foreach($cities as $city){
            $output .= '<option value="'. $city->id .'">'. $city->name .'</option>';
        }
        // $output .= '</select>';

        return $output;
    }

    public function getMetaPrice(Request $request){
        $product = $request->product;
        $attrValues = (array)$request->values;
        asort($attrValues);

        // Generate Value String
        $string = '';
        foreach ($attrValues as $attrValue) {
            $string .= $attrValue . '.';
        }

        // Get Product Meta
        $query = ProductMeta::where('product_id', $product)->where('attribute_value_ids', $string)->first();

        if ($query) {
            return response()->json([
                'success' => true,
                'price' => $query->selling_price,
                'attribute_string' => $query->attribute_string_json,
                'old_price' => $query->old_price
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }

    public function fbTrack(Request $request){
        $data = array();
        $data['event_type'] = $request->event_type;
        $data['event_time'] = time();
        $data['custom_data'] = array();
        if($request->value){
            $data['custom_data']['value'] = $request->value;
        }
        if($request->currency){
            $data['custom_data']['currency'] = $request->currency;
        }
        if($request->content_name){
            $data['custom_data']['content_name'] = $request->content_name;
        }
        if($request->content_type){
            $data['custom_data']['content_type'] = $request->content_type;
        }
        if($request->content_ids){
            $data['custom_data']['content_ids'] = '['. $request->content_ids .']';
        }
        if($request->num_items){
            $data['custom_data']['num_items'] = 1;
        }
        if($request->quantity){
            $data['custom_data']['quantity'] = $request->quantity;
        }
        if($request->id){
            $data['custom_data']['id'] = $request->id;
        }

        // $data = array(
        //     'event_type' => $request->event_type,
        //     'event_time' => time(),
        //     'custom_data' => array(
        //         'value' => 120,
        //         'currency' => 'USD',
        //         'content_name' => 'Product Name',
        //         'content_type' => 'product',
        //         'content_ids' => '[1234567890]',
        //         'num_items' => 1,
        //     )
        // );
        FBTrackingRepo::track($request->access_token, $request->pixel_id, $data);

        return 'success';
    }

    public function landing($id){
        try{
            $landing = LandingBuilder::find($id);
            $products = Product::whereIn('id', $landing->products_id)->get();
            if(!count($products)){
                abort(404);
            }
            $product = $products[0];
            $states = cache()->remember('get_states', (60 * 60 * 24 * 90), function(){
                $json = json_decode(file_get_contents('https://oms.cutpricebd.com/api/v2/get-states'), true);
                if(isset($json['data'])){
                    return $json['data'];
                }
                return [];
            });

            return view('landing.showBuilder', compact('landing', 'products', 'product', 'states'));
        }catch(\Exception $e){
            return view('front.not-found-page');
        }
    }
}
