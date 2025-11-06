<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps=false;
    protected $fillable=['invoice_id','paid_at','amount','method','reference','created_by','created_at'];
    public function invoice(){ return $this->belongsTo(Invoice::class); }
}
