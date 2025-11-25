<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        // Pas aan als je permissies wilt afdwingen (bv. check role)
        return true;
    }

    public function rules()
    {
        return [
            'company_name'        => 'required|string|max:255',
            'contact_name'        => 'nullable|string|max:255',
            'contact_email'       => 'nullable|email|max:255',
            'contact_phone'       => 'nullable|string|max:50',
            'status'              => 'nullable|string|max:50',
            'bkr_status'          => 'nullable|string|max:50',
            'invoice_address_id'  => 'nullable|string|max:255', 
            'delivery_address_id' => 'nullable|string|max:255', 
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => 'Vul een bedrijfsnaam in.',
            'contact_email.email'   => 'Voer een geldig e-mailadres in.',
        ];
    }
}