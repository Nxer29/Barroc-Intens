<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public $timestamps=false;
    protected $fillable=['product_id','quantity','min_threshold','location','updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getIsBelowThresholdAttribute(): bool
    {
        return $this->quantity < $this->min_threshold;
    }
    public function inventory()
    {
        return $this->hasOne(\App\Models\Inventory::class);
    }
}
