<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['order_number','customer_id','product_id','quantity','order_date','status'];
}
