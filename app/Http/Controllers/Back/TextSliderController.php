<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\TextSlider;
use Illuminate\Http\Request;

class TextSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = TextSlider::orderBy('position')->get();

        return view('back.text-slider.index', compact('sliders'));
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
            'text' => 'required|max:255',
            'url' => 'required|max:1000'
        ]);

        $text_slider = new TextSlider;
        $text_slider->text = $request->text;
        $text_slider->url = $request->url;
        $text_slider->save();

        return redirect()->back()->with('success-alert', 'Slider created successful.');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TextSlider $text_slider)
    {
        $text_slider->delete();

        return redirect()->back()->with('error-alert', 'Slider deleted sucessfully.');
    }

    public function editAjax(Request $request){
        $slider = TextSlider::find($request->id);

        return vieW('back.text-slider.editAjax', compact('slider'));
    }

    public function updateAjax(Request $request){
        $request->validate([
            'slider' => 'required',
            'text' => 'required|max:255',
            'url' => 'required|max:1000'
        ]);

        $slider = TextSlider::findOrFail($request->slider);

        $slider->text = $request->text;
        $slider->url = $request->url;
        $slider->save();

        return redirect()->back()->with('success-alert', 'Slider updated successful.');
    }

    public function position(Request $request){
        foreach ($request->position as $i => $data) {
            $query = TextSlider::find($data);
            $query->position = $i;
            $query->save();
        }

        return redirect()->back()->with('success-alert', 'Position updated successful.');
    }
}
