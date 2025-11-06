<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    public $timestamps=false;
    protected $fillable=['quote_id','product_id','quantity','unit_price','line_total','description'];
    public function quote(){ return $this->belongsTo(Quote::class); }
}
