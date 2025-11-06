<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable=['company_name','contact_name','contact_email','contact_phone','status','bkr_status','invoice_address_id','delivery_address_id','created_by'];
    public function invoiceAddress(){ return $this->belongsTo(Address::class,'invoice_address_id'); }
    public function deliveryAddress(){ return $this->belongsTo(Address::class,'delivery_address_id'); }
    public function creator(){ return $this->belongsTo(User::class,'created_by'); }
    public function quotes(){ return $this->hasMany(Quote::class); }
    public function contracts(){ return $this->hasMany(Contract::class); }
    public function invoices(){ return $this->hasMany(Invoice::class); }
}
