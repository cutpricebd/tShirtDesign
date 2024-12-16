<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Repositories\MediaRepo;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::latest('id')->get();

        return view('back.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v_data = [
            'client_name' => 'required|max:255',
            'testimonial' => 'required',
            'position' => 'required',
        ];
        $v_data['image'] = 'required|mimes:jpg,png,jpeg,gif';
        $request->validate($v_data);

        $brand = new Testimonial;
        $brand->client_name = $request->client_name;
        $brand->testimonial = $request->testimonial;
        $brand->position = $request->position;

        if($request->file('image')){
            $uploaded_file = MediaRepo::upload($request->file('image'));
            $brand->image = $uploaded_file['full_file_name'];
            $brand->media_id = $uploaded_file['media_id'];
        }

        $brand->save();

        return redirect()->back()->with('success-alert', 'Created successful.');
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
    public function edit(Testimonial $testimonial)
    {
        return view('back.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'client_name' => 'required|max:255',
            'testimonial' => 'required',
            'position' => 'required',
        ]);


        $testimonial->client_name = $request->client_name;
        $testimonial->testimonial = $request->testimonial;
        $testimonial->position = $request->position;

        if($request->file('image')){
            $uploaded_file = MediaRepo::upload($request->file('image'));
            $testimonial->image = $uploaded_file['full_file_name'];
            $testimonial->media_id = $uploaded_file['media_id'];
        }

        $testimonial->save();

        return redirect()->back()->with('success-alert', 'Updated successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('back.testimonials.index')->with('success-alert', 'Deleted successful.');
    }
}
