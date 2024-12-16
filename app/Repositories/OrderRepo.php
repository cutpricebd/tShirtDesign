<?php

namespace App\Repositories;

use App\Models\Order\Order;
use App\Models\Order\OrderProduct;
use App\Models\Order\OrderStatus;
use App\Models\OrderPayment;
use App\Models\Product\ProductData;
use App\Models\ShippingCharge;

class OrderRepo {
    public static function paid($order_id){
        // $income = 0;
        $order = Order::find($order_id);

        // foreach($order->OrderProducts as $order_product){
        //     foreach($order_product->OrderProductStocks as $order_product_stock){
        //         if($order_product_stock->Stock->purchase_price){
        //             $profit_per_item = $order_product->sale_price - $order_product_stock->Stock->purchase_price;

        //             $income += $profit_per_item * $order_product_stock->quantity;
        //         }
        //     }
        //     // $income += 0;
        // }

        // dd($income);

        // Income
        if($order->grand_total > 0){
            AccountsRepo::income($order->grand_total, "Income from order #$order_id");
        }
    }

    public static function payment($id, $amount, $gateway_order_id, $txn_number, $note = null){
        $order_payment = new OrderPayment;
        $order_payment->order_id = $id;
        $order_payment->amount = $amount;
        $order_payment->gateway_order_id = $gateway_order_id;
        $order_payment->txn_number = $txn_number;
        $order_payment->note = $note;
        $order_payment->save();

        return $order_payment;
    }

    // Insert order status
    public static function status($order_id, $status, $added_by = null){
        $order_status = new OrderStatus;
        $order_status->order_id = $order_id;
        $order_status->status = $status;
        $order_status->added_by = $added_by;
        $order_status->save();
    }

    // Insert order products
    public static function product($order_id, $product_id, $product_data_id, $sale_price, $quantity){
        $product_data = ProductData::find($product_data_id);

        $order_product = new OrderProduct;
        $order_product->order_id = $order_id;

        $order_product->product_id = $product_id;
        $order_product->product_data_id = $product_data->id;
        $order_product->sale_price = $sale_price;
        $order_product->quantity = $quantity;

        $order_product->title = $product_data->Product->title ?? '';
        $order_product->attribute_item_ids = $product_data->attribute_item_ids;

        $order_product->shipping_weight = $product_data->shipping_weight ?? 0;

        // TAX
        $order_product->tax_amount = $product_data->tax_amount;
        $order_product->tax_type = $product_data->tax_type;
        $order_product->tax_method = $product_data->tax_method;

        $order_product->save();

        return $order_product;
    }

    public static function getShippingCharge($state, $country, $city = null){
        $charge = ShippingCharge::query();

        $charge->where('country', $country);
        $charge->where('state', $state);

        if($city){
            $charge->where('city', $city);
        }
        $charge = $charge->first();

        if($country == 'Canada'){
            if(!$charge && $state == 'Ontario'){
                $charge = ShippingCharge::where('state', 'Ontario')->where('country', 'Canada')->first();
            }

            if(!$charge && $country == 'Canada'){
                $charge = ShippingCharge::where('state', 'Any')->where('country', 'Canada')->first();
            }
        }else{
            if(!$charge){
                $charge = ShippingCharge::where('state', 'Any')->where('country', 'USA')->first();
            }
        }
        if(!$charge){
            $charge = ShippingCharge::where('state', 'Any')->first();
        }

        return $charge->amount ?? 0;
    }

    public static function index($order_id){
        $order = Order::find($order_id);

        $order_products = OrderProduct::where('order_id', $order_id)->get();

        $product_total = 0;
        foreach($order_products as $order_product){
            $product_total += $order_product->sale_price * $order_product->quantity;
        }

        $order->product_total = $product_total;
        $order->save();

        return true;
    }

    public static function updateCourierStatus($order_id){
        $order = Order::find($order_id);
        if(!$order){
            return false;
        }

        if($order->courier == 'Pathao'){
            if($order->status == 'In Courier'){
                $get_order = PathaoRepo::send('GET', "aladdin/api/v1/orders/{$order->courier_invoice}");
                if($get_order['status'] && ($get_order['response']['type'] ?? null) == 'success'){
                    $pathao_data = $get_order['response']['data'];

                    if(count($pathao_data)){
                        $order->courier_status = $get_order['response']['data']['order_status'];

                        if($pathao_data['billing_status'] == 'Paid'){
                            $order->courier_payment_status = 'Paid';
                        }
                        if($pathao_data['order_type'] == 'Delivery'){
                            if($pathao_data['order_status'] == 'Delivered'){
                                if($pathao_data['billing_status'] == 'Paid'){
                                    $order->status = 'Completed';
                                }else{
                                    $order->status = 'Delivered';
                                }
                            }elseif($pathao_data['order_status'] == 'Return'){
                                $order->status = 'Returned';
                            }
                        }elseif($pathao_data['order_type'] == 'Return'){
                            $order->status = 'Returned';
                        }
                        $order->save();

                        return true;
                    }
                    return true;
                }
            }
        }elseif($order->courier == 'REDX'){
            $get_order = RedxRepo::curl("parcel/track/{$order->courier_invoice}", 'GET');

            if($get_order['tracking'] && count($get_order['tracking'])){
                $last_index = count($get_order['tracking']) - 1;
                $order->courier_status = $get_order['tracking'][$last_index]['message_en'];
                $order->save();

                return redirect()->back()->with('success', 'Courier Status Updated!');
            }
        }elseif($order->courier == 'Steadfast'){
            if($order->status == 'In Courier'){
                $status = SteadFastRepo::status($order->courier_invoice);

                if(isset($status['delivery_status'])){
                    if($status['delivery_status'] == 'delivered'){
                        $order->status = 'Delivered';
                    }
                    if($status['delivery_status'] == 'cancelled'){
                        $order->status = 'Returned';
                    }

                    $order->courier_status = $status['delivery_status'];
                    $order->save();

                    return true;
                }
            }

            return true;
        }
    }
}
