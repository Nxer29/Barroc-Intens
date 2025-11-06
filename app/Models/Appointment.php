<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public $timestamps=false;
    protected $fillable=['maintenance_request_id','scheduled_start','scheduled_end','assignee_id','location','status','created_by','created_at'];
    public function workOrders(){ return $this->hasMany(WorkOrder::class); }
}
