<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['sku','name','brand','description','category_id','unit_price','price','is_visible_to_customers','stock'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class,'category_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}
