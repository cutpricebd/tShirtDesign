<?php

namespace App\Models\Order;

use App\Models\OrderPayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // Attachment Path
    public function getAttachmentPathAttribute(){
        if($this->attachment && file_exists(public_path('uploads/order', $this->attachment))){
            return asset('uploads/order/' . $this->attachment);
        }

        return null;
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullAddressAttribute()
    {
        return "{$this->street}";
    }

    public function getShippingFullAddressAttribute()
    {
        return "{$this->shipping_street}";
    }

    public function getCustomProductTotalAttribute(){
        return $this->product_total - $this->refund_product_total;
    }

    public function getGrandTotalAttribute()
    {
        return ($this->shipping_charge + $this->product_total + $this->tax_amount + $this->other_cost) - ($this->discount_amount + $this->refund_total_amount);
    }

    // Order Products
    public function OrderProducts(){
        return $this->hasMany(OrderProduct::class);
    }

    public function OrderPayments(){
        return $this->hasMany(OrderPayment::class);
    }

    public function getShippingWeightKgAttribute(){
        if($this->shipping_weight && $this->shipping_weight > 0){
            return $this->shipping_weight / 100;
        }
        return 0;
    }
}
