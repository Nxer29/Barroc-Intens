<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentType extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];
}
