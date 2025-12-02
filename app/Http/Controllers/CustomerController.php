<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Validatie (invoice/delivery als tekst)
        $data = $request->validate([
            'company_name'        => 'required|string|max:255',
            'contact_name'        => 'nullable|string|max:255',
            'contact_email'       => 'nullable|email|max:255',
            'contact_phone'       => 'nullable|string|max:50',
            'status'              => 'nullable|string|max:50',
            'invoice_address_id'  => 'nullable|string|max:255',
            'delivery_address_id' => 'nullable|string|max:255',
            'source'              => 'nullable|string|in:manual,online',
            'source_url'          => 'nullable|url|max:255',
        ]);

        $force = $request->boolean('force', false);

        // Duplicaat-detectie: e-mail, telefoon (genormaliseerd) en bedrijfsnaam-fragment
        $companyFragment = isset($data['company_name']) ? mb_strtolower(trim($data['company_name'])) : null;
        $email = $data['contact_email'] ?? null;
        $phone = isset($data['contact_phone']) ? preg_replace('/\D+/', '', $data['contact_phone']) : null;

        $matches = collect();

        if ($email) {
            $matches = $matches->merge(Customer::where('contact_email', $email)->take(10)->get());
        }

        if ($phone) {
            $matches = $matches->merge(
                Customer::whereRaw("REPLACE(REPLACE(REPLACE(contact_phone, ' ', ''), '+', ''), '-', '') = ?", [$phone])
                        ->take(10)->get()
            );
        }

        if ($companyFragment) {
            $frag = mb_substr($companyFragment, 0, 6);
            $matches = $matches->merge(
                Customer::whereRaw('LOWER(company_name) LIKE ?', ['%' . $frag . '%'])->take(10)->get()
            );
        }

        $matches = $matches->unique('id')->values();

        if ($matches->isNotEmpty() && ! $force) {
            // Stuur duplicaten terug naar view (create.blade toont ze)
            return back()->withInput()->with('duplicates', $matches);
        }

        // Vul created_by als ingelogd
        if (Auth::check()) {
            $data['created_by'] = Auth::id();
        }

        try {
            $customer = Customer::create($data);

            Log::info('Customer created', ['id' => $customer->id, 'data' => $data]);

            return redirect()->route('customers.show', ['customer' => $customer->id])
                             ->with('success', 'Klant aangemaakt.');
        } catch (\Throwable $e) {
            Log::error('Failed to create customer', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            // Voor development: toon foutmelding in formulier (vervang in productie door generieke melding)
            return back()->withInput()->withErrors(['general' => $e->getMessage()]);
        }
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }
}