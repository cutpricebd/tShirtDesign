<?php

namespace App\Console\Commands;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Traits\CommonTrait;
use Illuminate\Console\Command;

class ProductSlugAssignCommand extends Command
{
    use CommonTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product_assign:slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Existing product slug generate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::whereBetween('id',[1,3000])->get(['id','title','slug']);
        foreach ($products as $product){
            try {
                $slug = $this->makeSlug('products',$product->title,$product->id);
                $product->update(['slug'=>$slug]);
                print($product->id."\n");
            }catch (\Exception $e){
                print($product->id." Error update\n");
            }
        }

        /*$categories = Category::whereBetween('id',[1,3000])->get(['id','title','slug']);
        foreach ($categories as $category){
            try {
                $slug = $this->makeSlug('categories',$category->title,$category->id);
                $category->update(['slug'=>$slug]);
                print($category->id."\n");
            }catch (\Exception $e){
                print($category->id." Error update\n");
            }
        }*/
        $this->info("<br>updated successfully!");
    }
}
