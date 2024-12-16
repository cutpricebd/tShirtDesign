<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\LandingBuilder;
use App\Models\Page;
use App\Models\Product\Attribute;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductData;
use App\Models\Slider;
use App\Repositories\FBConversionRepo;
use Illuminate\Http\Request;
use DB;
use Info;

class PageController extends Controller
{
    // Homepage
    public function homepage(Request $request)
    {
        // $featured_categories = Category::where('for', 'product')->where('feature', 1)->active()->get();
        // $sliders = Slider::active()->get();
        // $testimonials = Testimonial::where('status', 1)->latest('id')->get();
        // $special_offers = SpecialOffer::with('product', 'product.ProductData')->where('status', 1)->orderBy('position')->take(3)->get();
        // $feature_ads = FeatureAds::where('placement', 'Place 1')->orderBy('position')->take(3)->get();
        // if(!$request->page){
        //     $products = cache()->remember('homepage_products', (60 * 60 * 24 * 90), function(){
        //         return Product::active()->select('id', 'title', 'image_path', 'image', 'regular_price', 'sale_price', 'slug')->paginate(24);
        //     });
        // }else{
        //     $products = Product::active()->select('id', 'title', 'image_path', 'image', 'regular_price', 'sale_price', 'slug')->paginate(24);
        // }

        //$product_ids = ProductCategory::where('category_id', 16)->pluck('product_id')->toArray();
        //$products = Product::whereIn('id', $product_ids)->select('id', 'title', 'image_path', 'image', 'regular_price', 'sale_price', 'slug')->active()->get();

        $categories = cache()->remember('homepage_categories', (60 * 60 * 24 * 90), function(){
            return Category::where('for', 'product')->where('category_id', null)->active()->select('id', 'title', 'slug')->get();
        });

        // $hot_deals = cache()->remember('hot_deals', (60 * 60 * 24 * 90), function(){
        //     return Product::where('spacial_offer', 1)->active(12)->select('id', 'title', 'image_path', 'image', 'regular_price', 'sale_price', 'slug')->get();
        // });

        // $sliders = cache()->remember('sliders', (60 * 60 * 24 * 90), function(){
        //     return Slider::active()->get();
        // });

        $sliders = Slider::orderBy('position')->get();

        $new_arrival_products = Product::where('spacial_offer', 1)->select('id', 'title', 'image_path', 'image', 'regular_price', 'sale_price', 'slug', 'type')->active(12)->get();

        $feature_category = Category::where('for', 'product')->where('feature', 1)->active(4)->select('id', 'title', 'slug', 'feature_image')->get();

        $collection_category = Category::where('for', 'product')->where('collection', 1)->active(6)->select('id', 'title', 'slug', 'collection_image')->get();

        $trending_product = Product::where('featured', 1)->with('categories')->select('id', 'title', 'image_path', 'image', 'slug', 'type')->active(2)->get();

        $products = Product::select('id', 'title', 'image_path', 'image', 'regular_price', 'sale_price', 'slug', 'type')->active(8)->get();

        return view('front.homepage', compact('products', 'categories', 'sliders', 'new_arrival_products', 'feature_category', 'collection_category', 'trending_product'));
    }

    public function category($slug){
        $category = Category::where('slug', $slug)->active()->first();
        if (!isset($category->id)){
            return view('front.not-found-page');
        }else{

            $productsCount = Product::count();
            $categories = Category::where(['status'=>1,'for'=>'product'])->get(['id','title','slug']);
            $attributes= Attribute::with(['AttributeItems'])->get();

            $product_ids = ProductCategory::where('category_id', $category->id)->pluck('product_id')->toArray();
            $products = Product::whereIn('id', $product_ids)->active()->paginate(28);
            return view('front.category', compact('category', 'products','productsCount','categories','attributes'));
        }
    }

    public function filterProduct(Request $request)
    {
        $category_id = $request->category_id;
        $values = $request->values; //example ["2","4"]

        $product_ids = ProductCategory::where('category_id', $category_id)->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $product_ids)
            ->where(function ($query) use ($values) {
            foreach ($values as $value) {
                $query->whereJsonContains('attribute_items_id', $value);
            }
        })->active()->paginate(28);
        return response()->json(['html'=>view('front.layouts.categoryProduct', compact( 'products'))->render()],200);
    }

    public function search(Request $request){
        $search = $request->search;
        $products = Product::query();
        $products->active();
        $products->where(function($q) use ($search){
            $q->where('id', $search)->orWhere('title', 'LIKE', "%$search%");
        });
        $total_count = $products->count();
        $products = $products->paginate(28);

        return view('front.search', compact('products', 'total_count', 'search'));
    }

    public function product($slug){
        $product = Product::where('slug', $slug)->active()->first();
        if (!isset($product->id)) return view('front.not-found-product');

        $cids = $product->Categories->pluck('id')->toArray();
        $related_products = ProductCategory::with('Product')
            ->join('products', 'products.id', '=', 'product_categories.product_id')
            ->where('products.status', 1)
            ->where('products.deleted_at', null)
            ->whereIn('category_id', $cids)
            ->where('product_categories.product_id', '!=', $product->id)
            ->select('product_categories.product_id')
            ->distinct()
            ->latest('product_categories.product_id')
            ->take(24)->get();
        $related_products = $related_products->pluck('Product');

        return view('front.product', compact('product', 'related_products'));
    }

    public function allHotDeals(){
        $products = Product::where('spacial_offer', 1)->active()->select('id', 'title', 'image_path', 'image', 'regular_price', 'sale_price', 'slug')->paginate(28);

        return view('front.allHotDeals', compact('products'));
    }

    public function variationPrice(Request $request){
        $output = [
            'status' => false,
            'price' => '',
            'sku' => '',
            'product_data_id' => '',
            'stock' => ''
        ];

        $product = $request->product;
        $attr_values = $request->values;

        $attr_values_string = implode(',', $attr_values) . ',';

        $product_data = ProductData::where('product_id', $product)->where('attribute_item_ids', $attr_values_string)->first();

        if($product_data){
            $output['status'] = true;
            $output['sale_price'] = $product_data->sale_price;
            $output['sku'] = $product_data->sku_code;
            $output['product_data_id'] = $product_data->id;
            $output['stock'] = $product_data->stock;
        }

        return $output;
    }

    public function fbTrack(Request $request){
        if(Info::Settings('fb_api', 'track') == 'Yes'){
            if(count((array)$request->data)){
                return FBConversionRepo::track($request->track_type, ((array)$request->data));
            }
            return FBConversionRepo::track($request->track_type);
        }

        return 'false';
    }

    public function landing($id){
        try{
            $landing = LandingBuilder::find($id);
            $products = Product::whereIn('id', $landing->products_id)->get();
            if(!count($products)){
                if (!isset($category->id)) return view('front.not-found-page');
            }
            $product = $products[0];
            $states = cache()->remember('get_states', (60 * 60 * 24 * 90), function(){
                $json = json_decode(file_get_contents('https://oms.cutpricebd.com/api/v2/get-states'), true);
                if(isset($json['data'])){
                    return $json['data'];
                }
                return [];
            });

            return view('landing.showBuilder', compact('landing', 'products', 'product', 'states'));
        }catch(\Exception $e){
            return view('front.not-found-page');
        }
    }

      public function notFound(Request $request)
       {
        return view('front.not-found-page');
        }





    public function blogs() {
        return view('front.blogs');
    }

    // public function about() {

    //     $data['aboutpage'] =  DB::table('aboutpage as ap')
    //     ->select('ap.*')
    //     ->get();



    //     return view('front.about', $data);

    // }


    public function about()
{
    $data = [
        'aboutpage' => DB::table('aboutpage')->select('*')->get()
    ];

    return view('front.about', $data);
}


    public function page($page)
    {
        $page = Page::where('slug', $page)->active()->first();
        if (!isset($page->id)) return view('front.not-found-page');
        return view('front.page', compact('page'));
    }


}
