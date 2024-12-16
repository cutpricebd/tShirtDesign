<?php

namespace App\Repositories;

use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use App\Models\Product\Review;

class ProductRepo
{
    public static function insertProductCategory($product_id, $category_id)
    {
        $category_relation = new ProductCategory;
        $category_relation->product_id = $product_id;
        $category_relation->category_id = $category_id;
        $category_relation->save();

        return $category_relation;
    }

    public static function filter($category, $brands, $prices, $discounts, $ratings, $skip, $take, $order, $brand = null)
    {
        $output = [
            'total_count' => 0,
            'items' => []
        ];

        $query = ProductCategory::query();
        $query->with('Product', 'Product.ProductData');
        $query->join('products', 'products.id', '=', 'product_categories.product_id');
        $query->join('product_data', 'product_data.product_id', '=', 'product_categories.product_id');
        $query->where('status', 1)->where('products.deleted_at', null);
        // $query->where('products.stock', '>', 0);

        if ($category) {
            $query->where('product_categories.category_id', $category);
        }

        if (count((array)$brands)) {
            $query->whereIn('products.brand_id', (array)$brands);
        }
        if($brand){
            $query->where('products.brand_id', $brand);
        }

        if (count((array)$prices)) {
            $start_price = 0;
            $end_price = 0;
            if(isset($prices[0])){
                $start_price = explode('-', $prices[0])[0];
            }

            foreach($prices as $price_data){
                $end_price = explode('-', $price_data)[1];
            }
            $query->where('product_data.sale_price', '>=', $start_price)->where('product_data.sale_price', '<=', $end_price);
        }

        if (count((array)$ratings)) {
            $query->whereIn('products.average_rating', (array)$ratings);
        }

        if (count((array)$discounts)) {
            if (in_array('all', $discounts)) {
                $query->where('product_data.regular_price', '!=', null);
            } else {
                foreach ((array)$discounts as $discount) {
                    $query->where('product_data.discount_percent', '>', $discount);
                }
            }
        }

        if ($order == 'Price Low-High') {
            $query->orderby('product_data.sale_price', 'ASC');
        } elseif ($order == 'Price High-Low') {
            $query->orderby('product_data.sale_price', 'DESC');
        } elseif ($order == 'Highest Rated') {
            $query->orderby('products.average_rating', 'DESC');
        } else {
            $query->orderby('products.id', 'DESC');
        }

        $query->select('product_categories.product_id');
        $query->distinct('product_categories.product_id');

        $output['total_count'] = $query->count();
        $output['items'] = $query->paginate(30);

        return $output;
    }

    public static function flashReviewRating($product_id){
        $reviews = Review::where('product_id', $product_id)->active()->get();
        $rating = 0;

        foreach($reviews as $review){
            $rating += $review->rating;
        }

        if($rating > 0){
            $average_rating = $rating / count($reviews);
        }else{
            $average_rating = 0;
        }

        $product = Product::find($product_id);
        $product->average_rating = $average_rating;
        $product->total_review = count($reviews);
        $product->save();

        return true;
    }

    public static function index($product_id){
        $product = Product::find($product_id);

        if($product){
            $product->sale_price = $product->prices['sale_price'] ?? 0;
            $product->regular_price = $product->prices['regular_price'] ?? 0;

            if($product->type == 'Variable'){
                $array = array();
                $datas = $product->VariableProductData;
                foreach($datas as $data){
                    foreach($data->attribute_items_arr as $attribute_item){
                        $array[] = $attribute_item;
                    }
                }
                $product->attribute_items_id = json_encode($array);
            }

            $product->save();
        }

        return true;
    }
}
