<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\Auditable;

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

    use Auditable;

    /**
     * =========================
     * RELATIES
     * =========================
     */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class)->latest();
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * =========================
     * HELPER METHODS
     * =========================
     */

    public function invoiceAddress()
    {
        return is_numeric($this->invoice_address_id)
            ? Address::find($this->invoice_address_id)
            : null;
    }

    public function deliveryAddress()
    {
        return is_numeric($this->delivery_address_id)
            ? Address::find($this->delivery_address_id)
            : null;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function displayName(): string
    {
        return $this->company_name
            ?? $this->contact_name
            ?? 'Onbekende klant';
    }
}
