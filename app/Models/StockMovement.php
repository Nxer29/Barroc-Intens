<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    public $timestamps=false;
    protected $fillable=['product_id','change','reason','reference_type','reference_id','performed_by','created_at'];
    public function product(){ return $this->belongsTo(Product::class); }
    public function performer(){ return $this->belongsTo(User::class,'performed_by'); }
}
