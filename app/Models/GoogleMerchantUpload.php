<?php

namespace App\Models;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleMerchantUpload extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function google_category(){
        return $this->belongsTo(GoogleProductCategory::class, 'google_category_id', 'category_id');
    }
}
