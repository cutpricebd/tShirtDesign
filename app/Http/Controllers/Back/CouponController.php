<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('code')->get();

        return view('back.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.coupon.create');
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
            'code' => 'required|max:255|unique:coupons',
            'description' => 'max:1000',
            'discount_type' => 'required',
            'amount' => 'required',
            'visibility' => 'required'
        ]);

        $coupon = new Coupon;
        $coupon->code = $request->code;
        $coupon->description = $request->description;
        $coupon->discount_type = $request->discount_type;
        $coupon->amount = $request->amount;
        $coupon->expiry_date = Carbon::parse($request->expiry_date);
        $coupon->minimum_spend = $request->minimum_spend;
        $coupon->maximum_spend = $request->maximum_spend;
        $coupon->maximum_use = $request->maximum_use;
        $coupon->visibility = $request->visibility;
        $coupon->user_id = $request->customer;
        $coupon->save();

        return redirect()->back()->with('success-alert', 'Coupon created successful.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        return view('back.coupon.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('back.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|max:255|unique:coupons,code,' . $coupon->id,
            'description' => 'max:1000',
            'discount_type' => 'required',
            'amount' => 'required',
            'visibility' => 'required'
        ]);

        $coupon->code = $request->code;
        $coupon->description = $request->description;
        $coupon->discount_type = $request->discount_type;
        $coupon->amount = $request->amount;
        $coupon->expiry_date = Carbon::parse($request->expiry_date);
        $coupon->minimum_spend = $request->minimum_spend;
        $coupon->maximum_spend = $request->maximum_spend;
        $coupon->maximum_use = $request->maximum_use;
        $coupon->visibility = $request->visibility;
        if($request->customer){
            $coupon->user_id = $request->customer;
        }
        $coupon->save();

        return redirect()->back()->with('success-alert', 'Coupon updated successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('back.coupons.index')->with('success-alert', 'Coupon deleted successful.');
    }
}
