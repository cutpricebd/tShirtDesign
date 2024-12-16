<?php

namespace App\Repositories;

use App\Models\Order\OrderProductStock;
use App\Models\Product\Adjustment;
use App\Models\Product\Product;
use App\Models\Product\ProductData;
use App\Models\Product\Stock;
use App\Models\Product\StockHistory;

class StockRepo {
    public static function flashQuantities($product_data_id){
        $total_stock = Stock::groupBy('product_data_id')->where('product_data_id', $product_data_id)->where('current_quantity', '!=', 0)->selectRaw('sum(current_quantity) as sum')->first();

        $product_data = ProductData::find($product_data_id);
        if($product_data){
            $product_data->stock = $total_stock ? $total_stock->sum : 0;
            $product_data->save();

            // Update Product
            if($product_data->type == 'Simple'){
                $product = Product::find($product_data->product_id);

                if($product){
                    $product->stock = $product_data->stock;
                    $product->save();
                }
                // dd($product);
            }else{
                $product_total_stock = ProductData::where('type', 'Variable')->groupBy('product_id')->where('product_id', $product_data->product_id)->selectRaw('sum(stock) as sum')->first();

                if($product_total_stock){
                    $product = Product::find($product_data->product_id);

                    if($product){
                        $product->stock = $product_total_stock->sum;
                        $product->save();
                    }
                }
            }
            // dd($product);
        }

        return true;
    }

    public static function stockSale($product_data_id, $quantity, $order_product_id = null){
        $stocks = Stock::where('current_quantity', '>', 0)->where('product_data_id', $product_data_id)->orderBy('id')->get();
        // dd($stocks);

        $remaining_quantity = $quantity;
        foreach($stocks as $stock){
            if($remaining_quantity > 0){
                $current_stock = $stock->current_quantity;
                $new_current_stock = $stock->current_quantity - $remaining_quantity;
                $remaining_quantity = $remaining_quantity - $current_stock;

                if($new_current_stock < 0){
                    $stock->current_quantity = 0;
                }else{
                    $stock->current_quantity = $new_current_stock;
                }
                $stock->save();

                // Add Order Product Stock
                if($order_product_id){
                    $order_product_stock = new OrderProductStock;
                    $order_product_stock->order_product_id = $order_product_id;
                    $order_product_stock->stock_id = $stock->id;
                    $order_product_stock->quantity = $current_stock - $new_current_stock;
                    $order_product_stock->save();
                }
            }
        }

        return true;
    }

    public static function adjustment($total_amount, $note = null){
        $adjustment = new Adjustment;
        $adjustment->total_amount = $total_amount;
        $adjustment->added_by = auth()->user()->full_name;
        $adjustment->note = $note;
        $adjustment->save();

        return $adjustment;
    }

    public static function stock($adjustment_id, $product_id, $product_data_id, $purchase_quantity, $current_quantity, $purchase_price, $note = null){
        $stock = new Stock;
        $stock->adjustment_id = $adjustment_id;
        $stock->product_id = $product_id;
        $stock->product_data_id = $product_data_id;

        $stock->purchase_quantity = $purchase_quantity;
        $stock->current_quantity = $current_quantity;
        $stock->purchase_price = $purchase_price;

        $stock->note = $note;
        $stock->save();

        // Flash Quantities
        (new static)->flashQuantities($stock->product_data_id);

        return $stock;
    }

    public static function hsitory($type, $product_id, $product_data_id, $quantity, $purchase_sale_price, $note = null, $added_by = null){
        // Product Data
        $product_data = ProductData::find($product_data_id);
        $previous_quantity = $product_data->stock;
        $product_data->stock += $quantity;
        // if($type == 'Addition'){
        // }else{
        //     $product_data->stock -= $quantity;
        // }
        $product_data->save();

        $stock_history = new StockHistory;
        $stock_history->type = $type;
        $stock_history->product_id = $product_id;
        $stock_history->product_data_id = $product_data_id;
        $stock_history->quantity = $quantity;
        $stock_history->previous_quantity = $previous_quantity;
        $stock_history->current_quantity = $product_data->stock;
        $stock_history->purchase_sale_price = $purchase_sale_price;
        $stock_history->note = $note;
        $stock_history->added_by = $added_by ?? (auth()->user()->full_name ?? null);
        $stock_history->save();

        // Refresh Product Total Quantity
        $product = $product_data->Product;
        if($product->type == 'Variable'){
            $total_qiantity = 0;
            foreach($product->VariableProductData as $variable_product_data){
                $total_qiantity += $variable_product_data->stock;
            }
        }else{
            $total_qiantity = $product_data->stock;
        }
        $product->stock = $total_qiantity;
        $product->save();

        return $stock_history;
    }
}
