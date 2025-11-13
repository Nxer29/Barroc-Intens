<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BkrCheck extends Model
{
    public $timestamps=false;
    protected $fillable=['customer_id','checked_by','status','checked_at','notes'];
}
