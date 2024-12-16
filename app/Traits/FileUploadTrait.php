<?php
namespace App\Traits;
use App\Models\Media;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Slider;
use Illuminate\Support\Facades\File;
use Info;
use Intervention\Image\ImageManagerStatic as Image;

trait FileUploadTrait{
    /*
     * method for image upload
     * */
    protected function imageConvertToWebp($start_id, $end_id)
    {
        set_time_limit(30000);
        ini_set('memory_limit','-1');
        $all_images = Media::whereBetween('id',[$start_id,$end_id])->get();
        foreach ($all_images as $all_image){
            //dd($all_image);
           // try {
                $original_path = $all_image->paths2['original'];
                $small_path = $all_image->paths2['small'];
                $medium_path = $all_image->paths2['medium'];
                $large_path = $all_image->paths2['large'];

                $rs = $this->uploadImg(public_path($original_path),'/uploads/'.$all_image->year.'/'.$all_image->month.'/');

                if (isset($rs['status']) && $rs['status']){
                    $all_image->update(['file_name'=>$rs['file_name']]);
                    $this->removeImage($original_path);
                    $this->removeImage($small_path);
                    $this->removeImage($medium_path);
                    $this->removeImage($large_path);
                }
                //dd($rs['status']);
            /*}catch (\Exception $e){

            }*/
        }

    }

    protected function productImage($start_id, $end_id)
    {
        set_time_limit('-1');
        ini_set('memory_limit','-1');
        $all_products = Product::whereBetween('id',[$start_id,$end_id])->withTrashed()->get(['id','image','media_id','image_path']);
        foreach ($all_products as $prod){
            print("id: ". $prod->id."\n");
            $med = Media::find($prod->media_id);
            if (isset($med->id)){
                $prod->update(['image'=>$med->file_name]);
            }
        }
    }

    protected function brandImage($start_id, $end_id)
    {
        set_time_limit('-1');
        ini_set('memory_limit','-1');
        $all_products = Brand::whereBetween('id',[$start_id,$end_id])->withTrashed()->get(['id','image','media_id']);
        foreach ($all_products as $prod){
            print("id: ". $prod->id."\n");
            $med = Media::find($prod->media_id);
            if (isset($med->id)){
                $prod->update(['image'=>$med->year.'/'.$med->month.'/'.$med->file_name]);
            }
        }
    }

    protected function categoryImage($start_id, $end_id)
    {
        set_time_limit('-1');
        ini_set('memory_limit', '-1');
        $all_products = Category::whereBetween('id', [$start_id, $end_id])->withTrashed()->get(['id', 'image', 'media_id']);
        foreach ($all_products as $prod) {
            print("id: " . $prod->id . "\n");
            $med = Media::find($prod->media_id);
            if (isset($med->id)) {
                $prod->update(['image' => $med->year . '/' . $med->month . '/' . $med->file_name]);
            }
        }
    }

    protected function sliderImage($start_id, $end_id)
    {
        set_time_limit('-1');
        ini_set('memory_limit','-1');
        $all_products = Slider::whereBetween('id',[$start_id,$end_id])->withTrashed()->get(['id','image','media_id','image_path']);
        foreach ($all_products as $prod){
            print("id: ". $prod->id."\n");
            $med = Media::find($prod->media_id);
            if (isset($med->id)){
                $prod->update(['image'=>$med->file_name]);
            }
        }
    }

    /*
     * method for remove file
     * */
    protected function removeImage($path){
        if(file_exists(public_path($path))){
            unlink(public_path($path));
        }
    }

    public function uploadImg($url, $path){
            print($url."\n");
            try {
                $image = $url;
                $small_width = Info::Settings('media', 'small_width') ?? 150;
                $small_height = Info::Settings('media', 'small_height') ?? 150;

                $medium_width = Info::Settings('media', 'medium_width') ?? 410;
                $medium_height = Info::Settings('media', 'medium_height') ?? 410;

                $large_width = Info::Settings('media', 'large_width') ?? 980;
                $large_height = Info::Settings('media', 'large_height') ?? 980;

                File::makeDirectory(public_path() .$path, $mode = 0777, true, true);
                $filename = uniqid().'.webp';

                // Resize Image large
                $image_resize = Image::make($image);
                $image_resize->encode('webp', 70);
                $image_resize->save(public_path($path .$filename));


                // Resize Image small
                $image_resize = Image::make($image);
                $image_resize->fit($small_width, $small_height);
                $image_resize->encode('webp', 70);
                $image_resize->encode('webp', 70);
                $image_resize->save(public_path($path . 'small_' . $filename));

                // Resize Image medium
                $image_resize = Image::make($image);
                $image_resize->fit($medium_width, $medium_height);
                $image_resize->encode('webp', 70);
                $image_resize->save(public_path($path . 'medium_' . $filename));

                // Resize Image large
                $image_resize = Image::make($image);
                $image_resize->fit($large_width, $large_height);
                $image_resize->encode('webp', 70);
                $image_resize->save(public_path($path . 'large_' . $filename));
                return [
                    'status' => true,
                    'file_name' => $filename,
                ];
            }catch (\Exception $e){
                print "error import\n";
                return [
                    'status' => false,
                ];
            }
    }
}
