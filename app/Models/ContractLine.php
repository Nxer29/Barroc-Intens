<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractLine extends Model
{
    public $timestamps=false;
    protected $fillable=['contract_id','product_id','quantity','monthly_beans','bean_type','unit_price','notes'];
    public function contract(){ return $this->belongsTo(Contract::class); }
}
