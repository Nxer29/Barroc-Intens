<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialsUsed extends Model
{
    public $timestamps=false;
    protected $fillable=['work_order_id','product_id','quantity','unit_price','created_at'];
}
