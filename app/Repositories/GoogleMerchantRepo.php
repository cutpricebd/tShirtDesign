<?php

namespace App\Repositories;

use App\ProductAttributeRel;
use Google_Client;
use Google_Service_ShoppingContent;

class GoogleMerchantRepo {
    public static function service(){
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('google-merchant-service-credentials.json'));
        $client->addScope(Google_Service_ShoppingContent::CONTENT);
        $service = new Google_Service_ShoppingContent($client);

        return $service;
    }

    public static function insertProduct($product, $google_category) {
        try{
            $service = (new static)->service();

            // Create a product resource
            $product_query = new \Google_Service_ShoppingContent_Product();

            // Set product details
            // $product->setOfferId($product->id);

            // Generate Attribute
            $sizes = array();
            foreach ($product->VariableAttributes as $attribute){
                if($attribute->name == 'Size'){
                    foreach ($attribute->AttributeItems as $attribute_item){
                        if(in_array($attribute_item->id, $product->attribute_items_arr)){
                            $sizes[] = $attribute_item->name;
                        }
                    }
                }
            }

            $product_query->setOfferId($product->id);
            $product_query->setTitle($product->title);
            $product_query->setDescription($product->description);
            $product_query->setImageLink($product->img_paths['original']);
            $product_query->setPrice(new \Google_Service_ShoppingContent_Price(['value' => $product->sale_price, 'currency' => env('GOOGLE_MERCHANT_CURRENCY', 'BDT')]));
            $product_query->setLink($product->route);
            $product_query->setSizes($sizes);
            $product_query->setGoogleProductCategory($google_category);
            $product_query->setAvailability('in stock');
            $product_query->setChannel('online');
            $product_query->setContentLanguage('en');
            $product_query->setTargetCountry('BD');
            $product_query->setBrand($product->Brand->title ?? env('GOOGLE_MERCHANT_BRAND', env('APP_NAME')));

            // Insert the product
            $insertedProduct = $service->products->insert(env('GOOGLE_MERCHANT_ID'), $product_query);

            if($insertedProduct->getId()){
                return [
                    'status' => true,
                    'message' => 'Product insert success.'
                ];
            }
            return [
                'status' => false,
                'message' => 'Product insert failed!'
            ];
        }catch(\Exception $e){
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
