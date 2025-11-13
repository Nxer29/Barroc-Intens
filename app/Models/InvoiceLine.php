<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    public $timestamps=false;
    protected $fillable=['invoice_id','product_id','description','quantity','unit_price','line_total'];
    public function invoice(){ return $this->belongsTo(Invoice::class); }
}
