<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    public $timestamps=false;
    protected $fillable=['quote_number','customer_id','created_by','created_at','valid_until','status','total_amount','preferences','machines_count','pdf_url'];
    public function customer(){ return $this->belongsTo(Customer::class); }
    public function items(){ return $this->hasMany(QuoteItem::class); }
}
