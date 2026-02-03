<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable=['request_number','customer_id','product_id','contract_id','reported_by','assigned_to','issue_description','urgency','priority','status','scheduled_at','feedback_text'];
    public function appointments(){ return $this->hasMany(Appointment::class); }
    public function customer()
{
    return $this->belongsTo(Customer::class);
}

public function contract()
{
    return $this->belongsTo(Contract::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}

public function reportedBy()
{
    return $this->belongsTo(User::class, 'reported_by');
}

public function assignedTo()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

}
