<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    public function Product(){
        return $this->belongsTo(Product::class);
    }

    public function ProductData(){
        return $this->belongsTo(ProductData::class);
    }
}
