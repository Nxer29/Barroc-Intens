<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalMessage extends Model
{
    public $timestamps=false;
    protected $fillable=['sender_id','receiver_id','customer_id','content','created_at'];
}
