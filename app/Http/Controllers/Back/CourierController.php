<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePermissionMiddleware;
use App\Models\eCourierLocations;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Info;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\PathaoRepo;
use App\Repositories\RedxRepo;
use App\Repositories\SteadFastRepo;
use App\Repositories\eCourierRepo;
use App\Repositories\OrderRepo;
use App\Repositories\PaperflyRepo;
use App\Repositories\ProductRepo;
use App\Repositories\StockRepo;
use Illuminate\Support\Facades\Storage;

class CourierController extends Controller
{
    public function config(){
        $courier_config = Info::SettingsGroupKey('courier');
        return view('back.courier.config', compact('courier_config'));
    }

    public function update(Request $request){
        $where = array();

        // Save Credentials
        $where['group'] = 'courier';

        if($request->enable_courier == 'Yes'){
            $insert['value'] = 'Yes';
        }else{
            $insert['value'] = 'No';
        }
        $where['name'] = 'enable_courier';
        DB::table('settings')->updateOrInsert($where, $insert);

        // Pathao
        if($request->pathao_enabled == 'Yes'){
            $insert['value'] = 'Yes';
        }else{
            $insert['value'] = 'No';
        }
        $where['name'] = 'pathao_enabled';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'pathao_client_id';
        $insert['value'] = $request->pathao_client_id;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'pathao_client_secret';
        $insert['value'] = $request->pathao_client_secret;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'pathao_username';
        $insert['value'] = $request->pathao_username;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'pathao_password';
        $insert['value'] = $request->pathao_password;
        DB::table('settings')->updateOrInsert($where, $insert);

        // REDX
        if($request->redx_enabled == 'Yes'){
            $insert['value'] = 'Yes';
        }else{
            $insert['value'] = 'No';
        }
        $where['name'] = 'redx_enabled';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'redx_api_token';
        $insert['value'] = $request->redx_api_token;
        DB::table('settings')->updateOrInsert($where, $insert);

        // Steadfast
        if($request->steadfast_enabled == 'Yes'){
            $insert['value'] = 'Yes';
        }else{
            $insert['value'] = 'No';
        }
        $where['name'] = 'steadfast_enabled';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'steadfast_api_key';
        $insert['value'] = $request->steadfast_api_key;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'steadfast_secret_key';
        $insert['value'] = $request->steadfast_secret_key;
        DB::table('settings')->updateOrInsert($where, $insert);

        // eCourier
        if($request->ecourier_enabled == 'Yes'){
            $insert['value'] = 'Yes';
        }else{
            $insert['value'] = 'No';
        }
        $where['name'] = 'ecourier_enabled';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'ecourier_api_key';
        $insert['value'] = $request->ecourier_api_key;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'ecourier_secret_key';
        $insert['value'] = $request->ecourier_secret_key;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'ecourier_user_id';
        $insert['value'] = $request->ecourier_user_id;
        DB::table('settings')->updateOrInsert($where, $insert);

        // Paperfly
        if($request->paperfly_enabled == 'Yes'){
            $insert['value'] = 'Yes';
        }else{
            $insert['value'] = 'No';
        }
        $where['name'] = 'paperfly_enabled';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'paperfly_api_key';
        $insert['value'] = $request->paperfly_api_key;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'paperfly_username';
        $insert['value'] = $request->paperfly_username;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'paperfly_password';
        $insert['value'] = $request->paperfly_password;
        DB::table('settings')->updateOrInsert($where, $insert);

        // Pidex
        if($request->pidex_enabled == 'Yes'){
            $insert['value'] = 'Yes';
        }else{
            $insert['value'] = 'No';
        }
        $where['name'] = 'pidex_enabled';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'pidex_merchant_id';
        $insert['value'] = $request->pidex_merchant_id;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'pidex_api_token';
        $insert['value'] = $request->pidex_api_token;
        DB::table('settings')->updateOrInsert($where, $insert);

        Artisan::call('cache:clear');
        if (Storage::exists('pathao_bearer_token.json')) {
            Storage::disk('local')->delete('pathao_bearer_token.json');
        }

        return redirect()->back()->with('success', 'Courier Credentials Updated!');
    }

    public function getPathaoInfo(Request $request){
        $locations_html = '';
        $stores = '';

        // Get Stores
        $get_stores = PathaoRepo::send('GET', 'aladdin/api/v1/stores', []);
        if(!$get_stores['status']){
            return [
                'status' => false
            ];
        }

        if(isset($get_stores['response']['type']) && $get_stores['response']['type'] == 'success'){
            foreach($get_stores['response']['data']['data'] as $store){
                $stores .= '<option value="'. $store['store_id'] .'">'. $store['store_name'] .'</option>';
            }
        }else{
            return [
                'status' => false
            ];
        }
        $location_json = file_get_contents(public_path('pathao-locations.json'));
        $locations = json_decode($location_json, true);
        if($request->type == '2'){
            // Get Cities
            $get_cities = PathaoRepo::send('GET', 'aladdin/api/v1/countries/1/city-list', []);

            if(isset($get_cities['response']['type']) && $get_cities['response']['type'] == 'success'){
                $cities = $get_cities['response']['data']['data'];

                $locations_html = view('back.orders.pathaoLocationsB', compact('cities'))->render();
            }else{
                return [
                    'status' => false
                ];
            }
        }else{
            $locations_html = view('back.orders.pathaoLocations', compact('locations'))->render();
        }

        return [
            'status' => true,
            'stores' => $stores,
            'locations_html' => $locations_html
        ];
    }

    public function updateCourierStatus($id){
        $order = Order::findOrFail($id);
        if(!$order->courier || !$order->courier_invoice){
            return redirect()->back()->with('error', 'Please submit to a courier first!');
        }

        $status = OrderRepo::updateCourierStatus($id);

        if($status){
            return redirect()->back()->with('success', 'Courier Status Updated!');
        }
        return redirect()->back()->with('error', 'Courier API Error!');
    }

    public function sendPathaoOrder($id, Request $request){
        $v_data = [
            'store' => 'required',
            'address' => 'required',
            'weight' => 'required',
            'collect_amount' => 'required',
            'note' => 'nullable|max:255'
        ];
        $request->validate($v_data);

        if($request->location){
            $locations = explode('::', $request->location);

            $city = $locations[2];
            $zone = $locations[1];
            $area = $locations[0];
        }else{
            $city = $request->city;
            $zone = $request->zone;
            $area = $request->area;
        }
        $order = Order::findOrFail($id);

        if($order->courier_invoice){
            return redirect()->back()->with('error', 'Sorry! Courier already submitted.');
        }

        // try{
            $response = DB::transaction(function() use($order, $city, $zone, $area, $request){
                $request_data = array();
                $request_data['store_id'] = $request->store;
                $request_data['merchant_order_id'] = '#' . $order->id;
                $request_data['recipient_name'] = $order->shipping_full_name;
                $request_data['recipient_phone'] = $request->phone_number;
                $request_data['recipient_address'] = $request->address;
                $request_data['recipient_city'] = $city;
                $request_data['recipient_zone'] = $zone;
                $request_data['recipient_area'] = $area;
                $request_data['item_weight'] = $request->weight;
                $request_data['delivery_type'] = 48;
                $request_data['item_type'] = 2;
                $request_data['item_quantity'] = 1;
                $request_data['special_instruction'] = $request->note;
                $request_data['amount_to_collect'] = $request->collect_amount ?? $order->grand_total;

                $create_order = PathaoRepo::send('POST', 'aladdin/api/v1/orders', $request_data);

                if($create_order['status']){
                    if($create_order['response']['type'] == 'error'){
                        $errors = array();

                        foreach((array)$create_order['response']['errors'] as $error){
                            $errors[] = $error[0] ?? '';
                        }

                        return [
                            'status' => false,
                            'message' => 'Pathao API error! ' . implode(', ', $errors)
                        ];
                    }

                    // Update Order
                    $order->courier = 'Pathao';
                    $order->courier_invoice = $create_order['response']['data']['consignment_id'];
                    $order->shipping_street = $request->address;
                    $order->courier_status = 'Pending';
                    $order->status = 'In Courier';
                    $order->courier_submitted_at = now();
                    $order->shipping_mobile_number = $request->phone_number;
                    $order->note = $request->note;
                    $order->save();

                    return [
                        'status' => true,
                        'message' => 'Pathao submitted success!'
                    ];
                }

                return [
                    'status' => false,
                    'message' => 'Pathao API Error!'
                ];
            });

            if($response['status']){
                return redirect()->back()->with('success', 'Pathao submitted success!');
            }

            return redirect()->back()->with('error', ($response['message'] ?? 'Pathao API error!'));
        // }catch(\Exception $e){
        //     return redirect()->back()->with('error', 'Pathao API error!');
        // }
    }

    public function getPathaoZone(Request $request){
        $zones = '<option value="">Select Zone</option>';

        // Get Zones
        $get_zones = PathaoRepo::send('GET', 'aladdin/api/v1/cities/'. $request->city_id .'/zone-list', []);

        if(isset($get_zones['response']['type']) && $get_zones['response']['type'] == 'success'){
            foreach($get_zones['response']['data']['data'] as $zone){
                $zones .= '<option value="'. $zone['zone_id'] .'">'. $zone['zone_name'] .'</option>';
            }

            return $zones;
        }

        return 'false';
    }

    public function getPathaoAreas(Request $request){
        $areas = '<option value="">Select Area</option>';

        // Get Areas
        $get_zones = PathaoRepo::send('GET', 'aladdin/api/v1/zones/'. $request->zone_id .'/area-list', []);

        if(isset($get_zones['response']['type']) && $get_zones['response']['type'] == 'success'){
            foreach($get_zones['response']['data']['data'] as $zone){
                $areas .= '<option value="'. $zone['area_id'] .'">'. $zone['area_name'] .'</option>';
            }

            return $areas;
        }

        return 'false';
    }

    public function getRedexInfo(Request $request){
        // Get Areas
        $get_areas = RedxRepo::curl('areas');
        if(!isset($get_areas['areas'])){
            return [
                'status' => false
            ];
        }
        $areas = $get_areas['areas'];

        // Get Stores
        $get_stores = RedxRepo::curl('pickup/stores');
        $stores = $get_stores['pickup_stores'];

        $html = view('back.orders.redexInfo', compact('areas', 'stores'))->render();

        return [
            'status' => true,
            'html' => $html,
        ];
    }

    public function sendRedexOrder($id, Request $request){
        $request->validate([
            'store' => 'required',
            'area' => 'required',
            'address' => 'required',
            'collect_amount' => 'required',
            'phone_number' => 'required',
            'weight' => 'required',
            'note' => 'nullable|max:255'
        ]);

        $order = Order::findOrFail($id);

        if($order->courier_invoice){
            return redirect()->back()->with('error', 'Sorry! Courier already submitted.');
        }

        $response = DB::transaction(function($order, $request, $id){
            $area_arr = explode('::', $request->area);
            $area_id = $area_arr[0] ?? '';
            $area_name = $area_arr[1] ?? '';

            $request_data_string = '{
                "customer_name": "'. $order->shipping_full_name .'",
                "customer_phone": "'. $request->phone_number .'",
                "delivery_area": "'. $area_name .'",
                "delivery_area_id": '. $area_id .',
                "customer_address": "'. $request->address .'",
                "merchant_invoice_id": "'. $id .'",
                "cash_collection_amount": "'. $request->collect_amount ?? $order->grand_total .'",
                "parcel_weight": '. $request->weight .',
                "value": 100,
                "instruction": "'. $request->note .'",
                "pickup_store_id": '. $request->store .'
            }';

            $create_order = RedxRepo::curl('parcel', 'POST', $request_data_string);

            if(!isset($create_order['tracking_id'])){
                return [
                    'status' => false,
                    'message' => 'Error from API!'
                ];
            }

            // Update Order
            $order->courier_invoice = $create_order['tracking_id'];
            $order->courier = 'REDX';
            $order->status = 'In Courier';
            $order->courier_submitted_at = now();
            $order->courier_status = 'Package is created successfully';
            $order->shipping_street = $request->address;
            $order->shipping_mobile_number = $request->phone_number;
            $order->note = $request->note;
            $order->courier_submitted_at = now();
            $order->save();

            return [
                'status' => true,
                'message' => 'REDX submitted success!'
            ];
        });

        if($response['status']){
            return redirect()->back()->with('success', 'Courier submitted success!');
        }

        return redirect()->back()->with('error', ($response['message'] ?? 'REDX API error!'));
    }

    public function sendSteadfastOrder($id, Request $request){
        $request->validate([
            'address' => 'required',
            'collect_amount' => 'required',
            'phone_number' => 'required',
            'note' => 'nullable|max:255'
        ]);

        $order = Order::findOrFail($id);

        if($order->courier_invoice){
            return redirect()->back()->with('error', 'Sorry! Courier already submitted.');
        }

        try{
            $response = DB::transaction(function() use($order, $request){
                $courier = SteadFastRepo::createOrder($order->id, $order->shipping_full_name, $request->phone_number, $request->address, ($request->collect_amount ?? $order->grand_total), $request->note);

                if(isset($courier['status']) && $courier['status'] == 200){
                    // Update Order
                    $order->status = 'In Courier';
                    $order->courier_invoice = $courier['consignment']['tracking_code'] ?? $courier['consignment']['invoice'];
                    $order->courier = 'Steadfast';
                    $order->courier_status = $courier['consignment']['status'] ?? 'in_review';
                    $order->shipping_street = $request->address;
                    $order->shipping_mobile_number = $request->phone_number;
                    $order->note = $request->note;
                    $order->courier_submitted_at = now();
                    $order->save();

                    return [
                        'status' => true,
                        'message' => 'Courier submitted success!'
                    ];
                }else{
                    if(isset($courier['errors'])){
                        $error_text = '';
                        foreach($courier['errors'] as $error){
                            foreach($error as $error_text_content){
                                $error_text .= $error_text_content . ' ';
                            }
                        }

                        return [
                            'status' => false,
                            'message' => $error_text
                        ];
                    }

                    return [
                        'status' => false,
                        'message' => $courier['message'] ?? 'Steadfast API error!'
                    ];
                }
            });

            if($response['status']){
                return redirect()->back()->with('success', 'Courier submitted success!');
            }

            return redirect()->back()->with('error', ($response['message'] ?? 'SteadFast API error!'));
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Steadfast API error!');
        }
    }

    public function getFotSteadFast(Request $request){
        $orders = Order::whereIn('id', (array)$request->orders)->get();

        return view('back.orders.getFotSteadFast', compact('orders'));
    }
    public function steadFastCreateAjax(Request $request){
        $response = DB::transaction(function() use($request){
            $order = Order::find($request->order_id);
            if(!$order){
                return '<span class="text-danger">Order fetch failed!</span>';
            }

            $courier = SteadFastRepo::createOrder($order->id, $order->shipping_full_name, $order->shipping_mobile_number, $order->shipping_street, $order->grand_total, $order->note);

            if(isset($courier['status']) && $courier['status'] == 200){
                // Update Order
                $order->status = 'In Courier';
                $order->courier_invoice = $courier['consignment']['tracking_code'] ?? $courier['consignment']['invoice'];
                $order->courier = 'Steadfast';
                $order->courier_status = $courier['consignment']['status'] ?? 'in_review';
                $order->courier_submitted_at = now();
                $order->save();

                return '<span class="text-danger">Submitted Success!</span>';
            }else{
                if(isset($courier['errors'])){
                    $error_text = '';
                    foreach($courier['errors'] as $error){
                        foreach($error as $error_text_content){
                            $error_text .= $error_text_content . ' ';
                        }
                    }

                    return '<span class="text-danger">'. $error_text .'</span>';
                }

                return '<span class="text-danger">'. ($courier['message'] ?? 'Steadfast API error!') .'</span>';
            }
        });

        return $response;
    }
}
