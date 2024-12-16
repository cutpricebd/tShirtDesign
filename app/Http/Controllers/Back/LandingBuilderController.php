<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\LandingBuilder;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingBuilderController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:admin');
    //     parent::__construct();
    // }

    public function index(){
        $landings = LandingBuilder::latest('id')->get();

        return view('back.landingBuilders.index', compact('landings'));
    }

    public function create(){
        return view('back.landingBuilders.create');
    }

    public function addProduct(Request $request){
        $product = Product::find($request->id);

        return '<tr>
                    <td>
                        <img style="max-height: 80px;" class="img-responsive" src="'. ($product->img_paths['medium'] ?? asset('img/small-error-image.png')) .'">

                        <input name="products[]" type="hidden" value="'. $product->id .'">
                    </td>
                    <td>'. ($product->title ?? $product->title) .'</td>
                    <td>
                        <button type="button" class="btn btn-danger removeProduct"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>';
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'theme' => 'required',
            'products' => 'required',
        ]);

        $products = (array)$request->products;
        if(!count($products)){
            return redirect()->back()->withInput()->with('error', 'Please select some product!');
        }

        $landing = new LandingBuilder;
        $landing->title = $request->title;
        $landing->products_id = $products;
        $landing->theme = $request->theme;
        $landing->head_code = $request->head_code;
        $landing->body_code = $request->body_code;
        $landing->footer_code = $request->footer_code;
        $landing->server_track = $request->server_site_track;
        $landing->pixel_id = $request->pixel_id;
        $landing->pixel_access_token = $request->pixel_access_token;
        $landing->save();

        return redirect()->route('back.landingBuilders.index')->with('success', 'Landing page created!');
    }

    public function edit($id){
        $landing = LandingBuilder::findOrFail($id);
        $products = Product::whereIn('id', $landing->products_id)->get();

        return view('back.landingBuilders.edit', compact('landing', 'products'));
    }

    public function update($id, Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'theme' => 'required',
            'products' => 'required',
        ]);
        $landing = LandingBuilder::findOrFail($id);

        $products = (array)$request->products;
        if(!count($products)){
            return redirect()->back()->withInput()->with('error', 'Please select some product!');
        }

        $landing->title = $request->title;
        $landing->products_id = $products;
        $landing->theme = $request->theme;
        $landing->head_code = $request->head_code;
        $landing->body_code = $request->body_code;
        $landing->footer_code = $request->footer_code;
        $landing->server_track = $request->server_site_track;
        $landing->pixel_id = $request->pixel_id;
        $landing->pixel_access_token = $request->pixel_access_token;
        $landing->save();

        return redirect()->route('back.landingBuilders.index')->with('success', 'Landing page updated!');
    }

    public function build($id){
        $landing = LandingBuilder::findOrFail($id);

        // Get CSS
        $manifest = json_decode(file_get_contents(public_path('build-landing/manifest.json')), true);

        // Get CSS
        if(file_exists(public_path('l-build/' . $id . '/style.css'))){
            $css = Storage::disk('l_css')->get($id . '/style.css');
        }else{
            $css = file_get_contents(public_path('build-landing/' . $manifest['resources/landing/css/app.css']['file']));
        }

        // Get HTML
        if(file_exists(resource_path('views/l-build/' . $id . '/index.blade.php'))){
            $environment = 'Development';
            $html = view('l-build.'. $id .'.index', compact('environment'))->render();
        }else{
            $html = view('landing.builder.' . $landing->theme)->render();
        }

        return view('back.landingBuilders.build', compact('landing', 'css', 'html'));
    }

    public function buildSave($id, Request $request){
        $landing = LandingBuilder::find($id);

        if($landing){
            Storage::disk('l_css')->put(($id . '/style.css'), $request->cssdata);

            $customize_html = str_replace('<div class="mt-6 border-primary border-2 p-3 rounded h-32 md:h-96 text-center"><h3 class="mt-5 text-2xl">Products &amp; Order Form</h3><p>This content are not editable!</p></div>', '
            @include("back.landingBuilders.order-form")', $request->htmldata);
            $customize_html = str_replace('', '', $customize_html);
            Storage::disk('l_views')->put(($id . '/index.blade.php'), $customize_html);

            return 'true';
        }
        return 'false';
    }
}
