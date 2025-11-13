<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable=['request_number','customer_id','product_id','contract_id','reported_by','assigned_to','issue_description','urgency','priority','status','scheduled_at','feedback_text'];
    public function appointments(){ return $this->hasMany(Appointment::class); }
}
