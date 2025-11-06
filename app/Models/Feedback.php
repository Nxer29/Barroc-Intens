<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public $timestamps=false;
    protected $fillable=['customer_id','user_id','staff_id','message','created_at'];
}
