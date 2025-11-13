<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $timestamps=false;
    protected $fillable=['invoice_number','contract_id','customer_id','issue_date','due_date','total_amount','status','sent_at','paid_at','created_at','approved_by'];
    public function customer(){ return $this->belongsTo(Customer::class); }
    public function lines(){ return $this->hasMany(InvoiceLine::class); }
}
