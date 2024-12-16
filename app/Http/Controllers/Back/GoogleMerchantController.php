<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Jobs\GoogleMerchantUploadJob;
use App\Models\GoogleMerchantUpload;
use App\Models\GoogleProductCategory;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use App\Repositories\GoogleMerchantRepo;
use Illuminate\Http\Request;

class GoogleMerchantController extends Controller
{
    // Upload
    public function upload(){
        $categories = GoogleProductCategory::get();
        $product_categories = Category::where('status', 1)->where('parent', null)->where('type', 'product')->get();

        return view('back.gm.upload', compact('categories', 'product_categories'));
    }

    public function productsTable(Request $request){
        // Get Data
        $columns = array(
            0 => 'id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $q = Product::query();
        $q->where('status', 1);

        // Category filter
        $cid = $request->category_id;
        if($cid && $cid != 'All'){
            $q->whereHas('CategoriesRel', function($c) use ($cid){
                $c->where('category', $cid);
            });
        }

        // Search Product
        if($request->input('search.value')){
            $search = $request->input('search.value');
            $q->where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%");
        }
        $totalFiltered = $q->count();
        $products = $q->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = array();
        if (!empty($products)) {
            foreach ($products as $dataItems) {
                //Generate Datatable
                $nestedData['add_item'] = '<button class="btn btn-info btn-sm addItem" data-id="'. $dataItems->id .'">Add Item</button><br/>' . $dataItems->id;
                $nestedData['image'] = '<input type="hidden" class="addItemID" value="'. $dataItems->id .'"><span class="image darazID" data-id="'. $dataItems->id .'"><img class="small" src="'. $dataItems->getImage() .'"/></span>';
                $nestedData['name'] = '<span class="name">'. $dataItems->name .'</span>';
                $nestedData['price'] = $dataItems->AllMeta[0]->selling_price ?? 0;
                $nestedData['type'] = '<span class="text-capitalize">'. $dataItems->type .'</span>';
                $nestedData['action'] = '<a href="' . route('productEdit', $dataItems->id) . '" class="btn btn-info btn-sm" title="Edit"><i class="fas fa-edit"></i></a>';
                $data[] = $nestedData;
            }
        }

        // Output
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return response()->json($json_data);
    }

    // Get Product
    public function gteProduct(Request $request){
        $ids = explode(',', $request->request_id);
        $query = Product::whereIn('id', $ids)->get();
        $categories = GoogleProductCategory::get();

        return view('back.gm.products', compact('query', 'categories'));
    }

    // Upload Submitted
    public function uploadSubmitted(Request $request){
        $product = Product::find($request->product_id);

        $response = GoogleMerchantRepo::insertProduct($product, $request->product_category);
        if($response['status']){
            return 'success';
        }
        return '<li>'. $product->id .': '. $response['message'] .'</li>';
    }

    // Create Category
    public function createCategory(){
        // set_time_limit(30000);
        // ini_set('memory_limit','1024M');
        // $file = asset('google-product-categories.txt');
        // // dd(url_encode());

        // $arr = explode(PHP_EOL, file_get_contents($file));

        // $query_arr = array();
        // foreach($arr as $key => $category){
        //     $cat = explode(' - ', $category);
        //     // $query = new GoogleProductCategory;
        //     $query_arr[$key]['category_id'] = $cat[0];
        //     $query_arr[$key]['name'] = $cat[1];
        //     // $query->category_id = $cat[0];
        //     // $query->name = $cat[1];
        //     // $query->save();
        //     // dd($cat);
        // }
        // // dd($query_arr);
        // DB::table('google_product_categories')->insert($query_arr);
        // dd('success');
    }

    public function uploadB(){
        $pending_items = GoogleMerchantUpload::with('product', 'google_category')->where('status', 'Pending')->latest('id')->get();
        $failed_items = GoogleMerchantUpload::with('product', 'google_category')->where('status', 'Failed')->latest('id')->get();
        $uploaded_items = GoogleMerchantUpload::with('product', 'google_category')->where('status', 'Uploaded')->latest('id')->get();

        $categories = GoogleProductCategory::get();
        $product_categories = Category::with('Categories')->where('category_id', null)->where('status', 1)->where('for', 'product')->get();

        return view('back.gm.uploadB', compact('categories', 'product_categories', 'pending_items', 'failed_items', 'uploaded_items'));
    }

    public function uploadBSubmit(Request $request){
        $request->validate([
            'website_category' => 'required',
            'google_category' => 'required',
        ]);

        $products = ProductCategory::where('category_id', $request->website_category)->whereHas('Product')->pluck('product_id')->toArray();

        foreach($products as $product){
            $google_merchant_uploads = new GoogleMerchantUpload;
            $google_merchant_uploads->product_id = $product;
            $google_merchant_uploads->google_category_id = $request->google_category;
            $google_merchant_uploads->save();

            GoogleMerchantUploadJob::dispatch($google_merchant_uploads->id);
        }

        return redirect()->back()->with('success', 'Product upload requested!');
    }

    public function uploadSubmitByProduct(Request $request){
        $request->validate([
            'products' => 'required',
            'google_category' => 'required',
        ]);

        $products = (array)$request->products;
        if(!count($products)){
            return redirect()->back()->with('error', 'Please select product to upload!');
        }

        foreach($products as $product){
            $google_merchant_uploads = new GoogleMerchantUpload;
            $google_merchant_uploads->product_id = $product;
            $google_merchant_uploads->google_category_id = $request->google_category;
            $google_merchant_uploads->save();

            GoogleMerchantUploadJob::dispatch($google_merchant_uploads->id);
        }

        return redirect()->back()->with('success', 'Product upload requested success!');
    }
}
