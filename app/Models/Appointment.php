<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'customer_id',
        'type_id',
        'technician_id',
        'scheduled_at',
        'status',
        'notes',
    ];
protected $casts = [
    'scheduled_at' => 'datetime',
];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function type()
    {
        return $this->belongsTo(AppointmentType::class, 'type_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
