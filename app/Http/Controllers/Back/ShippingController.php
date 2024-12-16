<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charges = ShippingCharge::orderBy('state')->get();

        return view('back.shipping.index', compact('charges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'country' => 'required',
            'state' => 'required',
            'city' => 'max:255',
            'amount' => 'max:255'
        ]);

        $charge = new ShippingCharge;
        $charge->country = $request->country;
        $charge->state = $request->state;
        $charge->city = $request->city;
        $charge->amount = $request->amount;
        $charge->save();

        return redirect()->back()->with('success-alert', 'Shipping charge created successful.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $charge = ShippingCharge::findOrFail($id);

        return view('back.shipping.edit', compact('charge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $charge = ShippingCharge::findOrFail($id);

        $request->validate([
            // 'state' => 'required',
            'city' => 'max:255',
            'amount' => 'max:255'
        ]);

        // $charge->state = $request->state;
        $charge->city = $request->city;
        $charge->amount = $request->amount;
        $charge->save();

        return redirect()->back()->with('success-alert', 'Shipping charge update successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $charge = ShippingCharge::findOrFail($id);

        $charge->delete();

        return redirect()->route('back.shippings.index')->with('success-alert', 'Shipping charge deleted successful.');
    }
}
