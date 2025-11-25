<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'company_name',
        'contact_name',
        'contact_email',
        'contact_phone',
        'status',
        'invoice_address_id',
        'delivery_address_id',
        'source',
        'source_url',
        'created_by',
    ];

    // Optionele helper: laad gekoppeld Address-model als invoice_address_id numeriek is
    public function invoiceAddressIfExists()
    {
        if (is_numeric($this->invoice_address_id) && class_exists(\App\Models\Address::class)) {
            return \App\Models\Address::find((int) $this->invoice_address_id);
        }
        return null;
    }

    public function deliveryAddressIfExists()
    {
        if (is_numeric($this->delivery_address_id) && class_exists(\App\Models\Address::class)) {
            return \App\Models\Address::find((int) $this->delivery_address_id);
        }
        return null;
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}