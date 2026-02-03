<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Klantenoverzicht + zoeken
     */
    public function index(Request $request)
    {
        $search = $request->input('q');

        $customers = Customer::query()
            ->when($search, function ($query) use ($search) {
                $query->where('company_name', 'like', "%{$search}%")
                      ->orWhere('id', $search);
            })
            ->orderBy('company_name')
            ->paginate(15)
            ->withQueryString();

        return view('customers.index', compact('customers', 'search'));
    }

    /**
     * Klant aanmaken
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Klant opslaan
     */
    public function store(Request $request)
    {
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

        // ===== Duplicaat-detectie =====
        $companyFragment = mb_strtolower(trim($data['company_name']));
        $email = $data['contact_email'] ?? null;
        $phone = isset($data['contact_phone'])
            ? preg_replace('/\D+/', '', $data['contact_phone'])
            : null;

        $matches = collect();

        if ($email) {
            $matches = $matches->merge(Customer::where('contact_email', $email)->take(10)->get());
        }

        if ($phone) {
            $matches = $matches->merge(
                Customer::whereRaw(
                    "REPLACE(REPLACE(REPLACE(contact_phone, ' ', ''), '+', ''), '-', '') = ?",
                    [$phone]
                )->take(10)->get()
            );
        }

        if ($companyFragment) {
            $frag = mb_substr($companyFragment, 0, 6);
            $matches = $matches->merge(
                Customer::whereRaw('LOWER(company_name) LIKE ?', ['%' . $frag . '%'])
                        ->take(10)
                        ->get()
            );
        }

        $matches = $matches->unique('id')->values();

        if ($matches->isNotEmpty() && ! $force) {
            return back()
                ->withInput()
                ->with('duplicates', $matches);
        }

        if (Auth::check()) {
            $data['created_by'] = Auth::id();
        }

        try {
            $customer = Customer::create($data);

            Log::info('Customer created', [
                'id' => $customer->id,
            ]);

            return redirect()
                ->route('customers.show', $customer)
                ->with('success', 'Klant aangemaakt.');
        } catch (\Throwable $e) {
            Log::error('Failed to create customer', [
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => $e->getMessage()]);
        }
    }

 
public function show(Customer $customer)
{
    // Laad ALLEEN bestaande relaties
    $customer->load([
        'notes',
        'creator',
        // 'contracts',   // TODO Sprint 2: relatie toevoegen
        // 'appointments',// TODO Sprint 2
        // 'orders',      // TODO Sprint 2
        // 'invoices',    // TODO Sprint 2
    ]);

    /**
     * Voorbereidende data voor dashboard / tabs
     * (zodat de view alvast klaar is)
     */
    $stats = [
        'contracts'    => 0, // TODO: Contract::where('customer_id', $customer->id)->count()
        'appointments' => 0, // TODO
        'orders'       => 0, // TODO
        'invoices'     => 0, // TODO
    ];

    return view('customers.show', compact('customer', 'stats'));
}

}