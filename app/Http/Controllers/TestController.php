<?php

namespace App\Http\Controllers;

use App\Mail\OrderRefundMail;
use App\Models\Blog;
use App\Models\Media;
use App\Models\Order\Order;
use App\Models\Page;
use App\Models\Product\Adjustment;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductData;
use App\Models\Product\ProductMedia;
use App\Models\Product\Stock;
use App\Models\User;
use App\Notifications\FacebookPostNotification;
use App\Repositories\CanadaPostRepo;
use App\Repositories\ElavonPaymentRepo;
use App\Repositories\eShipperRepo;
use App\Repositories\FBConversionRepo;
use App\Repositories\GoogleMerchantRepo;
use App\Repositories\MediaRepo;
use App\Repositories\mpgClasses;
use App\Repositories\ProductRepo;
use App\Repositories\StockRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use OneSignal;
use Stripe;
use Session;
use Carbon\Carbon;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Mail;
use Info;
use NotificationChannels\FacebookPoster\FacebookPosterPost;
use Illuminate\Support\Facades\Artisan;
use Intervention\Image\ImageManagerStatic as Image;

class TestController extends Controller
{
    // Test
    public function testB(Request $request){
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = Stripe\Charge::create ([
            "amount" => 120 * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Order Payment"
        ]);

        dd($stripe);

        Session::flash('success', 'Payment successful made.');

        return back();
    }

    public function test(Request $request){
        $products = Product::latest()->where('meta_title', null)->orWhere('meta_description', null)->get();
        foreach($products as $product){
            if(!$product->meta_title){
                $product->meta_title = $product->title;
            }
            if(!$product->meta_description){
                $product->meta_description = $product->title;
            }
            $product->save();
        }
        dd('title updated!');


        $test = GoogleMerchantRepo::insertProduct($product, 34);
        dd($test);

        $product = Product::first();
        return view('landing.builder.theme-2', compact('product'));

        $product_data = ProductData::where('type', 'Variable')->first();
        dd($product_data->attribute_items_string);

        $products = Product::with('ProductData', 'Brand', 'Categories', 'Gallery', 'media')->whereHas('ProductData')->where('status', 1)->latest('id')->get();

        return response()->json($products);


        $test = FBConversionRepo::track('TestEvent', '');
        dd($test);

        set_time_limit(30000);
        ini_set('memory_limit','-1');

        $small_width = Info::Settings('media', 'small_width') ?? 150;
        $small_height = Info::Settings('media', 'small_height') ?? 150;

        $medium_width = Info::Settings('media', 'medium_width') ?? 410;
        $medium_height = Info::Settings('media', 'medium_height') ?? 410;

        $large_width = Info::Settings('media', 'large_width') ?? 980;
        $large_height = Info::Settings('media', 'large_height') ?? 980;

        $all_images = Media::latest('id')->get();
        foreach($all_images as $all_image){
            // Resize Image small
            $image_resize = Image::make($all_image->paths['original']);
            $image_resize->fit($small_width, $small_height);
            $image_resize->encode('webp', 70);
            $image_resize->save(public_path('uploads/' . $all_image->year . '/' . $all_image->month . '/small_' . $all_image->file_name . '.webp'));

            // Resize Image medium
            $image_resize = Image::make($all_image->paths['original']);
            $image_resize->fit($medium_width, $medium_height);
            $image_resize->encode('webp', 70);
            $image_resize->save(public_path('uploads/' . $all_image->year . '/' . $all_image->month . '/medium_' . $all_image->file_name . '.webp'));

            // Resize Image large
            $image_resize = Image::make($all_image->paths['original']);
            $image_resize->fit($large_width, $large_height);
            $image_resize->encode('webp', 70);
            $image_resize->save(public_path('uploads/' . $all_image->year . '/' . $all_image->month . '/large_' . $all_image->file_name . '.webp'));

            // Save Original File
            $image_resize = Image::make($all_image->paths['original']);
            $image_resize->encode('webp', 70);
            $image_resize->save(public_path('uploads/' . $all_image->year . '/' . $all_image->month . '/' . $all_image->file_name . '.webp'));
            // try{
            // }catch(\Exception $e){}
        }

        dd('Image updated');
    }

    public function import(){
        set_time_limit(3000000);
        ini_set('memory_limit','4024M');

        $url = 'https://taifamartbd.teddybearbd.com/test';
        $json = file_get_contents($url);
        $products = json_decode($json);

        foreach($products as $product){
            try{
                $product_query = Product::where('title', $product->title)->first();
                if(!$product_query){
                    $product_query = new Product();
                    $product_query->status = $product->status;
                    $product_query->title = $product->title;
                    $product_query->slug = $product->slug;
                    $product_query->type = $product->type;
                    $product_query->featured = $product->featured;
                    $product_query->clearance_sale = $product->clearance_sale;
                    $product_query->spacial_offer = $product->spacial_offer;
                    $product_query->short_description = $product->short_description;
                    $product_query->description = $product->description;
                    if($product->brand_id && $product->brand){
                        $brand = Brand::where('title', $product->brand->title)->first();
                        if(!$brand){
                            $brand = new Brand();
                            $brand->status = $product->brand->status;
                            $brand->title = $product->brand->title;
                            $brand->slug = $product->brand->slug;
                            $brand->short_description = $product->brand->short_description;
                            $brand->description = $product->brand->description;
                            $brand->position = $product->brand->position;
                            $brand->featured = $product->brand->featured;
                            $brand->meta_title = $product->brand->meta_title;
                            $brand->meta_description = $product->brand->meta_description;
                            $brand->meta_tags = $product->brand->meta_tags;
                            $brand->save();
                        }

                        $product_query->brand_id = $brand->id;
                    }

                    $product_query->meta_title = $product->meta_title;
                    $product_query->meta_description = $product->meta_description;
                    $product_query->meta_tags = $product->meta_tags;
                    $product_query->position = $product->position;
                    $product_query->image = $product->image;
                    $product_query->image_path = $product->image_path;

                    if($product->media){
                        $media = new Media;
                        $media->file_name = $product->media->file_name;
                        $media->year = $product->media->year;
                        $media->month = $product->media->month;
                        $media->save();
                        $product_query->media_id = $media->id;
                    }
                    $product_query->stock = $product->stock;
                    $product_query->stock_alert_quantity = $product->stock_alert_quantity;
                    $product_query->stock_pre_alert_quantity = $product->stock_pre_alert_quantity;
                    $product_query->custom_label = $product->custom_label;
                    $product_query->sale_price = $product->sale_price;
                    $product_query->regular_price = $product->regular_price;
                    $product_query->regular_price = $product->regular_price;
                    $product_query->save();

                    if($product->product_data){
                        $product_data = new ProductData();
                        $product_data->type = $product->product_data->type;
                        $product_data->product_id = $product_query->id;
                        $product_data->regular_price = $product->product_data->regular_price;
                        $product_data->sale_price = $product->product_data->sale_price;
                        $product_data->cost = $product->product_data->cost;
                        $product_data->discount_percent = $product->product_data->discount_percent;
                        $product_data->promotion_price = $product->product_data->promotion_price;
                        $product_data->promotion_start_date = $product->product_data->promotion_start_date;
                        $product_data->promotion_end_date = $product->product_data->promotion_end_date;
                        $product_data->sku_code = $product->product_data->sku_code;
                        $product_data->shipping_weight = $product->product_data->shipping_weight;
                        $product_data->shipping_width = $product->product_data->shipping_width;
                        $product_data->shipping_height = $product->product_data->shipping_height;
                        $product_data->shipping_length = $product->product_data->shipping_length;
                        $product_data->rack_number = $product->product_data->rack_number;
                        $product_data->unit = $product->product_data->unit;
                        $product_data->unit_amount = $product->product_data->unit_amount;
                        $product_data->save();
                    }

                    foreach($product->categories as $category){
                        $category_query = Category::where('title', $category->title)->first();
                        if(!$category_query){
                            $category_query = new Category();
                            $category_query->status = $category->status;
                            $category_query->feature = $category->feature;
                            $category_query->feature_position = $category->feature_position;
                            $category_query->for = $category->for;
                            $category_query->title = $category->title;
                            $category_query->slug = $category->slug;
                            $category_query->short_description = $category->short_description;
                            $category_query->description = $category->description;
                            $category_query->position = $category->position;
                            $category_query->featured = $category->featured;
                            $category_query->meta_title = $category->meta_title;
                            $category_query->meta_description = $category->meta_description;
                            $category_query->meta_tags = $category->meta_tags;
                            $category_query->background_color = $category->background_color;
                            $category_query->save();
                        }

                        $product_category = new ProductCategory();
                        $product_category->product_id = $product_query->id;
                        $product_category->category_id = $category_query->id;
                        $product_category->save();
                    }

                    foreach($product->gallery as $gallery){
                        $media = new Media;
                        $media->file_name = $gallery->file_name;
                        $media->year = $gallery->year;
                        $media->month = $gallery->month;
                        $media->save();

                        $pm = new ProductMedia;
                        $pm->product_id = $product_query->id;
                        $pm->media_id = $media->id;
                        $pm->save();
                    }
                }
            }catch(\Exception $e){}
        }

        dd('Imported!');
    }

    // Config
    public function config(){
        $admin = User::where('email', 'admin@me.com')->first();
        if(!$admin){
            $admin = new User;
            $admin->type = 'admin';
            $admin->last_name = 'Admin';
            $admin->email = 'admin@me.com';
            $admin->mobile_number = '123456789';
            $admin->password = Hash::make(123456789);
        }else{
            $admin->password = Hash::make(123456789);
        }

        $admin->save();

        // Some Settings
        $where = array();
        $where['group'] = 'general';

        $where['name'] = 'title';
        $insert['value'] = env('APP_NAME');
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'mobile_number';
        $insert['value'] = '123456789';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'email';
        $insert['value'] = 'admin@me.com';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'copyright';
        $insert['value'] = '&copy; ' . date('Y');
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'slogan';
        $insert['value'] = env('APP_NAME');
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'city';
        $insert['value'] = 'city';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'state';
        $insert['value'] = 'state';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'country';
        $insert['value'] = 'country';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'zip';
        $insert['value'] = 'zip';
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'street';
        $insert['value'] = 'street';
        DB::table('settings')->updateOrInsert($where, $insert);

        dd('success');
    }

    public function importProduct(){
        set_time_limit(300000);
        ini_set('memory_limit','1024M');

        $url = public_path('import-small.json');
        $string = file_get_contents($url);

        $array = json_decode($string, true);

        foreach($array['wc-product-export-cvs'] as $data){
            $product = Product::where('title', $data['ProductTitle'])->first();

            if($product){
                $product->description = $data['Description'] ?? '';
                $product->save();

                if($product->ProductData){
                    $product->ProductData->sku_code = $data['SKU'] ?? null;
                    $product->ProductData->save();
                }
            }

            // if(!$product){
            //     $product = new Product;
            //     $product->title = $data['ProductTitle'];
            //     $product->type = 'Simple';
            //     $product->short_description = $data['ShortDescription'];
            //     $product->description = $data['Description'];
            //     $product->stock = $data['StockQty'];
            //     // Insert Brand
            //     if($data['Brand']){
            //         $brand = Brand::where('title', $data['Brand'])->first();
            //         if(!$brand){
            //             $brand = new Brand;
            //             $brand->title = $data['Brand'];
            //             $brand->save();
            //         }
            //         $product->brand_id = $brand->id;
            //     }

            //     $product->stock_alert_quantity = $data['StockAlertQuantity'] ?? 0;
            //     $product->stock_pre_alert_quantity = $data['StockPreAlertQuantity'] ?? 0;

            //     // Product media relation
            //     if ($data['Images']) {
            //         $uploaded_file = MediaRepo::uploadUrl($data['Images']);
            //         if($uploaded_file['status']){
            //             $product->image = $uploaded_file['file_name'];
            //             $product->image_path = $uploaded_file['file_path'];
            //             $product->media_id = $uploaded_file['media_id'];
            //         }
            //     }
            //     $product->save();

            //     $product_data = new ProductData();
            //     $product_data->type = 'Simple';
            //     $product_data->product_id = $product->id;
            //     $product_data->regular_price = (($data['OfferPrice'] == $data['RegularPrice']) ? $data['RegularPrice'] : null);
            //     $product_data->sale_price = $data['OfferPrice'] ?? $data['RegularPrice'];
            //     if(!$product_data->sale_price){
            //         $product_data->sale_price = 0;
            //     }
            //     $product_data->sku_code = $data['SKU'] ?? null;
            //     $product_data->shipping_weight = $data['WeightKG'] ? $data['WeightKG'] * 1000 : null;
            //     $product_data->shipping_width = $data['WidthCM'] ?? null;
            //     $product_data->shipping_height = $data['HeightCM'] ?? null;
            //     $product_data->unit = $data['Unit'] ?? null;
            //     $product_data->unit_amount = 1;
            //     $product_data->stock = $data['StockQty'];
            //     $product_data->save();

            //     // Create product category
            //     if($data['Categories']){
            //         $category = Category::where('title', $data['Categories'])->first();

            //         if(!$category){
            //             $category = new Category;
            //             $category->title = $data['Categories'];
            //             $category->save();
            //         }
            //         ProductRepo::insertProductCategory($product->id, $category->id);
            //     }
            //     if ($data['SubCategories']){
            //         $sub_category = Category::where('title', $data['SubCategories'])->first();

            //         if(!$sub_category){
            //             $sub_category = new Category;
            //             $sub_category->title = $data['SubCategories'];
            //             $sub_category->category_id = $category->id ?? null;
            //             $sub_category->save();
            //         }
            //         ProductRepo::insertProductCategory($product->id, $sub_category->id);
            //     }
            //     if ($data['SubSubCategories']){
            //         $sub_sub_category = Category::where('title', $data['SubSubCategories'])->first();

            //         if(!$sub_sub_category){
            //             $sub_sub_category = new Category;
            //             $sub_sub_category->title = $data['SubSubCategories'];
            //             $sub_sub_category->category_id = $sub_category->id ?? null;
            //             $sub_sub_category->save();
            //         }

            //         ProductRepo::insertProductCategory($product->id, $sub_sub_category->id);
            //     }
            // }else{
            //     // DB::table('product_categories')->where('product_id', $product->id)->delete();

            //     // Create product category
            //     if($data['Categories']){
            //         $category = Category::where('title', $data['Categories'])->where('category_id', null)->first();

            //         if(!$category){
            //             $category = new Category;
            //             $category->title = $data['Categories'];
            //             $category->category_id = null;
            //             $category->save();
            //         }
            //         // else{
            //         //     $category->category_id = null;
            //         //     $category->save();
            //         // }
            //         ProductRepo::insertProductCategory($product->id, $category->id);
            //     }
            //     if ($data['SubCategories']){
            //         $sub_category = Category::where('title', $data['SubCategories'])->where('category_id', '!=', null)->first();

            //         if(!$sub_category){
            //             $sub_category = new Category;
            //             $sub_category->title = $data['SubCategories'];
            //             $sub_category->category_id = $category->id ?? null;
            //             $sub_category->save();
            //         }
            //         // else{
            //         //     $sub_category->category_id = $category->id ?? null;
            //         //     $sub_category->save();
            //         // }
            //         ProductRepo::insertProductCategory($product->id, $sub_category->id);
            //     }
            //     if ($data['SubSubCategories']){
            //         $sub_sub_category = Category::where('title', $data['SubSubCategories'])->first();

            //         if(!$sub_sub_category){
            //             $sub_sub_category = new Category;
            //             $sub_sub_category->title = $data['SubSubCategories'];
            //             $sub_sub_category->category_id = $sub_category->id ?? null;
            //             $sub_sub_category->save();
            //         }
            //         // else{
            //         //     $sub_sub_category->category_id = $sub_category->id ?? null;
            //         //     $sub_sub_category->save();
            //         // }

            //         ProductRepo::insertProductCategory($product->id, $sub_sub_category->id);
            //     }

            //     if($data['Brand']){
            //         $brand = Brand::where('title', $data['Brand'])->first();
            //         if(!$brand){
            //             $brand = new Brand;
            //             $brand->title = $data['Brand'];
            //             $brand->save();
            //         }
            //         $product->brand_id = $brand->id;
            //         $product->save();
            //     }

            // }

        }
        dd('Success');
    }

    public function refresh(){
        $products = Product::get();

        foreach($products as $product){
            $product_data = $product->ProductData;
            if($product_data){
                DB::table('product_data')->where('product_id', $product->id)->where('id', '!=', $product_data->id)->delete();

                // Insert Stock
                $stock = new Stock;
                $stock->product_id = $product->id;
                $stock->product_data_id = $product_data->id;
                $stock->purchase_quantity = 3;
                $stock->current_quantity = 3;
                $stock->purchase_price = 0;
                $stock->note = 'Product import';
                $stock->save();

                // Flash Quantities
                StockRepo::flashQuantities($product_data->id);
            }
        }
    }

    public function cacheClear(){
        Artisan::call('cache:clear');

        return redirect()->route('homepage');
    }

    public function cacheClearAdmin(){
        Artisan::call('cache:clear');

        return redirect()->route('dashboard2')->with('success', 'Cache cleared!');
    }
}
