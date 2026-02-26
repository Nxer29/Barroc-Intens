<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Contract extends Model
{
    protected $fillable = [
        'customer_id',
        'name',
        'start_date',
        'end_date',
        'status',
        'recurring_amount',
        'created_by',
        'bkr_status',
        'bkr_status_date',
        'bkr_note',
    ];

    use Auditable;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'bkr_status_date' => 'date',
        'recurring_amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'contract_product')
            ->withPivot(['quantity', 'unit_price'])
            ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
