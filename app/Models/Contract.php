<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable=['contract_number','quote_id','customer_id','signed_at','start_date','end_date','billing_cycle','pdf_url','status','bkr_checked','bkr_passed','created_by'];
    public function customer(){ return $this->belongsTo(Customer::class); }
    public function lines(){ return $this->hasMany(ContractLine::class); }
}
