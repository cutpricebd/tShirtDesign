<?php

namespace App\Http\Controllers\Back\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Adjustment;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductData;
use App\Models\Product\Stock;
use App\Repositories\AccountsRepo;
use App\Repositories\StockRepo;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    public function index(){
        $adjustments = Adjustment::latest('id')->withTrashed()->get();

        return view('back.product.adjustment.index', compact('adjustments'));
    }

    public function create(Request $request){
        if($request->product_id){
            $product = Product::findOrFail($request->product_id);
        }else{
            $product = null;
        }
        $categories = Category::where('category_id', null)->where('for', 'product')->active()->get();

        return view('back.product.adjustment.create', compact('categories', 'product'));
    }

    public function addItem(Request $request){
        $product = Product::find($request->id);

        if($product){
            return view('back.product.adjustment.addItem', compact('product'))->render();
        }
        return '';
    }

    public function getCost(Request $request){
        $data = ProductData::where('id', $request->variation_id)->first();

        if($data){
            return $data->cost;
        }
        return '';
    }

    public function store(Request $request){
        $request->validate([
            'grand_total' => 'required',
            'note' => 'required',
            'product' => 'required',
        ]);

        // Adjustment
        $adjustment = new Adjustment;
        $adjustment->total_amount = $request->grand_total;
        $adjustment->added_by = auth()->user()->full_name;
        $adjustment->note = $request->note;
        $adjustment->save();

        foreach($request->product as $key => $product_id){
            $stock = new Stock;
            $stock->adjustment_id = $adjustment->id;
            $stock->product_id = $product_id;
            $stock->product_data_id = $request->product_data_id[$key];
            if($request->type[$key] == 'Addition'){
                $stock->purchase_quantity = $request->quantity[$key];
                $stock->current_quantity = $request->quantity[$key];
                $stock->purchase_price = $request->price[$key] ?? 0;
            }else{
                $stock->purchase_quantity = 0 - $request->quantity[$key];
                $stock->current_quantity = 0;
                $stock->purchase_price = 0;

                StockRepo::stockSale($stock->product_data_id, $request->quantity[$key]);
            }
            $stock->note = $request->note;
            // $stock->user_id = $request->supplier;
            $stock->save();

            // Flash Quantities
            StockRepo::flashQuantities($stock->product_data_id);
        }

        // Store Expense
        if($request->grand_total > 0){
            AccountsRepo::expense($request->grand_total, "Expense for product purchase");
            AccountsRepo::accounts('Debit', $request->grand_total, "Expense for product purchase");
        }

        return redirect()->route('back.adjustments.index')->with('success-alert', 'Stock added successful.');
    }

    // public function edit(Adjustment $adjustment){

    //     return view('back.product.adjustment.edit', compact('adjustment'));
    // }

    public function delete(Request $request){
        $request->validate([
            'adjustment_id' => 'required',
            'delete_note' => 'required|max:255'
        ]);

        $adjustment = Adjustment::findOrFail($request->adjustment_id);
        $adjustment->delete_note = $request->delete_note;
        $adjustment->save();

        foreach($adjustment->Stocks as $stock){
            StockRepo::stockSale($stock->product_data_id, $stock->purchase_quantity);

            // Flash Quantities
            StockRepo::flashQuantities($stock->product_data_id);
        }

        $adjustment->delete();

        return view('back.product.adjustment.edit', compact('adjustment'))->with('success-alert', 'Adjustment deleted successful!');
    }
}
