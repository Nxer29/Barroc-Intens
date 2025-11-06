<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps=false;
    protected $fillable=['sender_id','receiver_id','receiver_role_id','related_customer_id','content','created_at'];
}
