<?php

namespace App\Models\Order;

use App\Models\Product\AttributeItem;
use App\Models\Product\Product;
use App\Models\Product\ProductData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    public function Product(){
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function ProductData(){
        return $this->belongsTo(ProductData::class)->withTrashed();
    }

    public function OrderProductStocks(){
        return $this->hasMany(OrderProductStock::class);
    }

    public function Order(){
        return $this->belongsTo(Order::class);
    }

    public function getCalculatedTaxAmountAttribute(){
        if($this->tax_method == 'Exclusive' && $this->quantity > $this->return_quantity){
            if($this->tax_type == 'Percentage'){
                return (($this->sale_price * ($this->quantity - $this->return_quantity)) * $this->tax_amount) / 100;
            }else{
                return $this->tax_amount;
            }
        }
        return 0;
    }

    public function getAttributeItemsAttribute()
    {
        $attr_items = explode(',', $this->attribute_item_ids);

        $item_id_arr = array();
        foreach ($attr_items as $attr_item) {
            if ($attr_item) {
                $item_ids = explode(':', $attr_item);

                $item_id_arr[] = $item_ids[1];
            }
        }

        $items = AttributeItem::with('Attribute')->whereIn('id', $this->attribute_items_arr)->get();

        return $items;
    }

    public function getAttributeItemsArrAttribute()
    {
        $attr_items = explode(',', $this->attribute_item_ids);

        $item_id_arr = array();
        foreach ($attr_items as $attr_item) {
            if ($attr_item) {
                $item_ids = explode(':', $attr_item);

                $item_id_arr[] = $item_ids[1];
            }
        }

        return $item_id_arr;
    }

    public function getAttributeItemsStringAttribute()
    {
        $string = '';
        $attribute_items = $this->attribute_items;
        foreach ($attribute_items as $key => $attributes_item) {
            $string .= ($attributes_item->Attribute->name ?? 'n/a') . ": $attributes_item->name" . (count($attribute_items) != ($key + 1) ? ", " : '');
        }

        return $string;
    }
}
