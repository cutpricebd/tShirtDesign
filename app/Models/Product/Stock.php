<?php

namespace App\Models\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    public function Product(){
        return $this->belongsTo(Product::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function ProductData(){
        return $this->belongsTo(ProductData::class);
    }
}
