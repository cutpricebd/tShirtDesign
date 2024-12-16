<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product\Cart;
use App\Models\Product\Product;
use App\Models\Product\ProductData;
use App\Repositories\CartRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart(){
        // Refresh
        CartRepo::refresh();

        $carts = CartRepo::summary();
        return view('front.cart', compact('carts'));
    }
    public function add(Request $request){
        try {
            $quantity = $request->quantity ?? 1;
            $summary = $this->storeCart($request->product_id, $quantity);

            return [
                'status' => true,
                'cart_count' => $summary['count'] ?? 0
            ];
        }catch (\Exception $e){
            return [
                'status' => true,
                'cart_count' => 0
            ];
        }
    }

    public function directOrder(request $request){
        /*if(!$request->product){
            return view('front.not-found-page');
        }
        try {
            $quantity = $request->quantity ?? 1;
            $this->storeCart($request->product, $quantity, $request->product_data_id);

            return redirect('cart',301)->with('success-alert', 'Card added success!');
        }catch (\Exception $e){
            return view('front.not-found-page');
        }*/
        //dd($request->all());
        // Check if product is provided in the request
        if (!$request->product) {
            return redirect()->route('front.not-found')->with('error-alert', 'Product not found!');
        }

        try {
            // Set default quantity to 1 if not provided
            $quantity = $request->quantity ?? 1;

            // Call storeCart method to handle adding product to cart
            $this->storeCart($request->product, $quantity, $request->product_data_id);

            // Redirect to cart page using 302 (temporary redirect) and display success message
            return redirect()->route('cart')->with('success-alert', 'Product added to cart successfully!');
        } catch (\Exception $e) {

            // Redirect to a not-found or error page if something goes wrong
            return redirect()->route('front.not-found')->with('error-alert', 'Something went wrong!');
        }
    }

    public function storeCart($product_id, $quantity, $data_id = null){
        $product = Product::find($product_id);
        if($data_id){
            $product_data = ProductData::find($data_id);
        }else{
            if($product->type == 'Variable'){
                $product_data = $product->VariableProductData[0];
            }else{
                $product_data = $product->ProductData;
            }
        }
        // if($product_data && $product_data->stock < 1){
        //     return [
        //         'status' => false,
        //         'text' => 'Out of Stock!',
        //         'cart_summary' => false,
        //         'new_item' => ''
        //     ];
        // }

        $session_id = Session::getId();

        $cart = Cart::query();
        if(auth()->check()){
            $cart->where('user_id', auth()->user()->id);
        }else{
            $cart->where('session_id', $session_id);
        }
        $cart = $cart->where('product_id', $product_id)->where('product_data_id', $product_data->id)->first();

        if($cart){
            return '0';
        }

        $cart = new Cart;

        if(auth()->check()){
            $cart->user_id = auth()->user()->id;
        }else{
            $cart->session_id = $session_id;
        }
        $cart->product_id = $product_id;
        $cart->product_data_id = $product_data->id;
        $cart->quantity = $quantity > 0 ? $quantity : 1;
        $cart->save();

        return CartRepo::summary();
    }

    public function remove($id){
        $cart = Cart::find($id);

        // Check if the cart item exists
        if (!isset($cart->id)) {
            return redirect()->route('cart')->with('error-alert', 'Cart item not found!');
        }

        // If the cart item exists, delete it
        $cart->delete();

        // Redirect to a defined route (such as the cart overview) instead of back()
        return redirect()->route('cart')->with('success-alert', 'Cart item deleted!');
    }

    public function update(Request $request){
        try {
            $cart = Cart::find($request->cart_id);
            if(isset($cart->id)){
                $cart->quantity = $request->quantity;
                $cart->save();
            }

            return [
                'summary' => CartRepo::summary(),
                'single_amount' => $cart->ProductData->sale_price * $cart->quantity
            ];
        }catch (\Exception $e){
            return [];
        }

    }

    public function checkout(Request $request)
    {
        // Refresh
        CartRepo::refresh();

        $carts = CartRepo::summary();
        return view('front.checkout', compact('carts'));
    }
}
