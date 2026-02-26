<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Product;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContractController extends Controller
{

    // Lijst
    public function index()
    {
        $contracts = Contract::with('customer')->latest()->get();
        return view('contracts.index', compact('contracts'));
    }

    // Formulier
    public function create()
    {
        $customers = Customer::select('id','company_name')->get();
        $products = Product::select('id','name','price')->get();
        return view('contracts.create', compact('customers','products'));
    }

    // Opslaan (simpel en robuust: we zetten eigenschappen direct om mass-assignment issues te vermijden)
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'name'             => 'nullable|string|max:255',
            'start_date'       => 'required|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
            'status'           => 'nullable|string|max:50',
            'bkr_status'        => 'nullable|in:not_started,in_progress,approved,rejected',
            'bkr_status_date'   => 'nullable|date',
            'bkr_note'          => 'nullable|string',
            'recurring_amount' => 'nullable|numeric|min:0',
            'products'         => 'nullable|array',
            'products.*'       => 'integer|exists:products,id',
            'quantities'       => 'nullable|array',
            'quantities.*'     => 'integer|min:1',
            'unit_prices'      => 'nullable|array',
            'unit_prices.*'    => 'numeric|min:0',
        ]);

        try {
            // Maak model instance en zet properties direct
            $contract = new Contract();
            $contract->contract_number  = $request->input('contract_number')
                                           ?? 'CN-' . time() . '-' . Str::upper(Str::random(6));
            $contract->customer_id      = $data['customer_id'];
            $contract->name             = $data['name'] ?? null;
            $contract->start_date       = $data['start_date'];
            $contract->end_date         = $data['end_date'] ?? null;
            $contract->status           = $data['status'] ?? null;

            // BKR status (per contract)
            $contract->bkr_status      = $data['bkr_status'] ?? 'not_started';
            $contract->bkr_status_date = $data['bkr_status_date'] ?? null;
            $contract->bkr_note        = $data['bkr_note'] ?? null;

            // Als er een status is gezet maar geen datum, zet hem op vandaag
            if ($contract->bkr_status !== 'not_started' && empty($contract->bkr_status_date)) {
                $contract->bkr_status_date = now()->toDateString();
            }

            $contract->recurring_amount = $data['recurring_amount'] ?? null;
            $contract->created_by       = Auth::id();
            $contract->save(); // direct save zorgt dat contract_number echt in DB staat

            // Sync producten (indien aanwezig)
            if (!empty($data['products']) && is_array($data['products']) && method_exists($contract, 'products')) {
                $sync = [];
                foreach ($data['products'] as $pid) {
                    $quantity  = $data['quantities'][$pid] ?? 1;
                    $unitPrice = $data['unit_prices'][$pid] ?? null;

                    $sync[$pid] = [
                        'quantity'   => (int) $quantity,
                        'unit_price' => $unitPrice,
                    ];
                }
                $contract->products()->sync($sync);
            }

            return redirect()->route('contracts.show', $contract)->with('success', 'Contract aangemaakt.');
        } catch (\Throwable $e) {
            Log::error('Contract create failed', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['general' => $e->getMessage()]);
        }
    }

    // Bekijken
    public function show(Contract $contract)
    {
        $contract->load(['customer','products']);

        // Laatste wijzigingen (wie/wanneer) in beeld brengen via audit logs
        $auditLogs = AuditLog::with('user')
            ->where('entity', 'Contract')
            ->where('entity_id', $contract->id)
            ->orderByDesc('timestamp')
            ->limit(20)
            ->get();

        return view('contracts.show', compact('contract', 'auditLogs'));
    }

    // Bewerken formulier
    public function edit(Contract $contract)
    {
        $customers = Customer::select('id','company_name')->get();
        $products = Product::select('id','name','price')->get();
        $contract->load('products');
        return view('contracts.create', compact('contract','customers','products'));
    }

    // Update (ook simpel)
    public function update(Request $request, Contract $contract)
    {
        $data = $request->validate([
            'contract_number'   => 'nullable|string|unique:contracts,contract_number,' . $contract->id,
            'customer_id'       => 'required|exists:customers,id',
            'name'              => 'nullable|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after_or_equal:start_date',
            'status'            => 'nullable|string|max:50',
            'bkr_status'         => 'nullable|in:not_started,in_progress,approved,rejected',
            'bkr_status_date'    => 'nullable|date',
            'bkr_note'           => 'nullable|string',
            'recurring_amount'  => 'nullable|numeric|min:0',
            'products'          => 'nullable|array',
            'products.*'        => 'integer|exists:products,id',
            'quantities'        => 'nullable|array',
            'quantities.*'      => 'integer|min:1',
            'unit_prices'       => 'nullable|array',
            'unit_prices.*'     => 'numeric|min:0',
        ]);

        try {
            // direct property assignment voorkomt problemen met $fillable
            $contract->contract_number  = $request->input('contract_number') ?? $contract->contract_number;
            $contract->customer_id      = $data['customer_id'];
            $contract->name             = $data['name'] ?? null;
            $contract->start_date       = $data['start_date'];
            $contract->end_date         = $data['end_date'] ?? null;
            $contract->status           = $data['status'] ?? null;

            // BKR status (per contract)
            $oldBkrStatus = $contract->bkr_status;
            $contract->bkr_status      = $data['bkr_status'] ?? $contract->bkr_status ?? 'not_started';
            $contract->bkr_status_date = $data['bkr_status_date'] ?? $contract->bkr_status_date;
            $contract->bkr_note        = $data['bkr_note'] ?? $contract->bkr_note;

            // Als status verandert en er is geen datum ingevuld, zet hem op vandaag
            if ($contract->bkr_status !== $oldBkrStatus && empty($data['bkr_status_date'])) {
                $contract->bkr_status_date = now()->toDateString();
            }

            $contract->recurring_amount = $data['recurring_amount'] ?? null;
            $contract->save();

            if (isset($data['products']) && is_array($data['products']) && method_exists($contract, 'products')) {
                $sync = [];
                foreach ($data['products'] as $pid) {
                    $quantity  = $data['quantities'][$pid] ?? 1;
                    $unitPrice = $data['unit_prices'][$pid] ?? null;

                    $sync[$pid] = [
                        'quantity'   => (int) $quantity,
                        'unit_price' => $unitPrice,
                    ];
                }
                $contract->products()->sync($sync);
            }

            return redirect()->route('contracts.show', $contract)->with('success', 'Contract bijgewerkt.');
        } catch (\Throwable $e) {
            Log::error('Contract update failed', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['general' => $e->getMessage()]);
        }
    }

    // Verwijderen
    public function destroy(Contract $contract)
    {
        try {
            if (method_exists($contract, 'products')) {
                $contract->products()->detach();
            }
            $contract->delete();
            return redirect()->route('contracts.index')->with('success', 'Contract verwijderd.');
        } catch (\Throwable $e) {
            Log::error('Contract delete failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }
}
