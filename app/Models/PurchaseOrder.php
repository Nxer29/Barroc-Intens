<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class PurchaseOrder extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id', 'quantity', 'status', 'created_at', 'approved_by', 'requested_by', 'total_cost'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

use Auditable;
