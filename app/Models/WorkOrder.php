<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class WorkOrder extends Model
{
    use Auditable;

    public $timestamps = false;
    protected $fillable = ['appointment_id', 'performed_by', 'notes', 'created_at', 'sent_to_manager', 'manager_received_at', 'external_reference'];

    public function materials()
    {
        return $this->hasMany(MaterialsUsed::class);
    }
}
