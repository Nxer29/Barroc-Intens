<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Order extends Model
{
    use Auditable;
    protected $fillable = ['order_number', 'customer_id', 'product_id', 'quantity', 'order_date', 'status'];
}
