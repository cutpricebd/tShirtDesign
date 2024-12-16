<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\FeatureAds;
use App\Repositories\MediaRepo;
use Illuminate\Http\Request;

class FeatureAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads_1 = FeatureAds::where('placement', 'Place 1')->orderBy('position')->get();
        $ads_2 = FeatureAds::where('placement', 'Place 2')->orderBy('position')->get();
        $ads_3 = FeatureAds::where('placement', 'Place 3')->orderBy('position')->get();
        $banner = FeatureAds::where('placement', 'Banner')->orderBy('position')->first();

        return view('back.feature-ads.index', compact('ads_1', 'ads_2', 'ads_3', 'banner'));
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
            'title' => 'max:255',
            'placement' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif'
        ]);

        if($request->placement == 'Banner'){
            $banner = FeatureAds::where('placement', 'Banner')->first();

            if($banner){
                return redirect()->back()->with('error-alert2', 'Banner ad already added');
            }
        }

        $ad = new FeatureAds;
        $ad->placement = $request->placement;
        $ad->title = $request->title;
        $ad->description = $request->description;

        $uploaded_file = MediaRepo::upload($request->file('image'));
        $ad->image = $uploaded_file['file_name'];
        $ad->image_path = $uploaded_file['file_path'];
        $ad->media_id = $uploaded_file['media_id'];

        $ad->save();

        return redirect()->back()->with('success-alert', 'Feature ad created successful.');
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
    public function edit(FeatureAds $feature_ad)
    {
        return view('back.feature-ads.edit', compact('feature_ad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeatureAds $feature_ad)
    {
        $request->validate([
            'title' => 'max:255',
            'description' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif'
        ]);

        $feature_ad->title = $request->title;
        $feature_ad->description = $request->description;

        if($request->file('image')){
            $uploaded_file = MediaRepo::upload($request->file('image'));
            $feature_ad->image = $uploaded_file['file_name'];
            $feature_ad->image_path = $uploaded_file['file_path'];
            $feature_ad->media_id = $uploaded_file['media_id'];
        }

        $feature_ad->save();

        return redirect()->back()->with('success-alert', 'Feature ad updated successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(FeatureAds $feature_ad)
    {
        $feature_ad->delete();

        return redirect()->back()->with('success-alert', 'Feature ad deleted successful.');
    }

    public function position(Request $request){
        foreach ($request->position as $i => $data) {
            $query = FeatureAds::find($data);
            $query->position = $i;
            $query->save();
        }

        return redirect()->back()->with('success-alert', 'Position updated successful.');
    }
}
