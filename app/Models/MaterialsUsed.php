<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialsUsed extends Model
{
    public $timestamps=false;
    protected $fillable=['work_order_id','product_id','quantity','unit_price','created_at'];

    public function workOrder(){ return $this->belongsTo(WorkOrder::class,'work_order_id'); }
    public function product(){ return $this->belongsTo(Product::class,'product_id'); }
}
