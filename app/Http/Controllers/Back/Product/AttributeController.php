<?php

namespace App\Http\Controllers\Back\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Attribute;
use App\Models\Product\AttributeItem;
use App\Models\Product\ProductData;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::orderBy('name')->get();

        return view('back.product.attribute.index', compact('attributes'));
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
            'name' => 'required|max:255'
        ]);

        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->save();

        return redirect()->back()->with('success-alert', 'Attribute created successful.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        return view('back.product.attribute.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        return view('back.product.attribute.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $attribute->name = $request->name;
        $attribute->save();

        return redirect()->back()->with('success-alert', 'Attribute updated successful.');
    }
    public function updateModal(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $attribute = Attribute::findOrFail($request->id);

        $attribute->name = $request->name;
        $attribute->save();

        return redirect()->back()->with('success-alert', 'Attribute updated successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        // Check Is Used
        $check_id = $attribute->id . ':';
        $product_data = ProductData::where('attribute_item_ids', 'LIKE', "%$check_id%")->first();
        if($product_data){
            return redirect()->back()->with('error', 'Attribute not deleted! This item already used on some products.');
        }

        $attribute->delete();

        return redirect()->back()->with('success-alert', 'Attribute deleted successful.');
    }

    // Store Items
    public function itemStore(Request $request){
        $request->validate([
            'attribute' => 'required',
            'name' => 'required|max:255'
        ]);

        $attribute_item = new AttributeItem;
        $attribute_item->name = $request->name;
        $attribute_item->attribute_id = $request->attribute;
        $attribute_item->save();

        return redirect()->back()->with('success-alert', 'Attribute item created successful.');
    }

    // Item Delete
    public function itemDestroy($id){
        // Check Is Used
        $check_id = ':' . $id . ',';
        $product_data = ProductData::where('attribute_item_ids', 'LIKE', "%$check_id%")->first();
        if($product_data){
            return redirect()->back()->with('error', 'Attribute not deleted! This item already used on some products.');
        }
        $attribute_item = AttributeItem::findOrFail($id);
        $attribute_item->delete();

        return redirect()->back()->with('success-alert', 'Attribute item deleted successful.');
    }

    // Item Edit
    public function itemEdit($id){
        $attribute_item = AttributeItem::findOrFail($id);

        return view('back.product.attribute.itemEdit', compact('attribute_item'));
    }
    public function itemUpdate(Request $request){
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $attribute_item = AttributeItem::findOrFail($request->id);
        $attribute_item->name = $request->name;
        $attribute_item->save();
        return redirect()->back()->with('success-alert', 'Attribute item updated successful.');
    }
}
