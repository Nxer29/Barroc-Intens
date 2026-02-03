<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Customer;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MaintenanceRequestController extends Controller
{
    /**
     * Maintenance queue (met filters)
     */
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['customer']);

        // 🔎 Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // 📌 Sortering: prioriteit + datum
        $requests = $query
            ->orderByRaw("
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('maintenance.requests.index', compact('requests'));
    }

    /**
     * Sales: storingsaanvraag aanmaken
     */
    public function create(Customer $customer)
    {
        $contracts = Contract::with('products')
            ->where('customer_id', $customer->id)
            ->get();

        return view('maintenance.requests.create', compact('customer', 'contracts'));
    }

    /**
     * Opslaan storingsaanvraag
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'       => 'required|exists:customers,id',
            'contract_id'       => 'required|exists:contracts,id',
            'product_id'        => 'required|exists:products,id',
            'issue_description' => 'required|string',
            'urgency'           => 'required|string',
            'priority'          => 'required|string',
        ]);

        $data['request_number'] = 'MR-' . strtoupper(Str::random(8));
        $data['reported_by'] = Auth::id();
        $data['status'] = 'open';

        MaintenanceRequest::create($data);

        return redirect()
            ->route('maintenance.requests.index')
            ->with('success', 'Storingsaanvraag is doorgestuurd naar Maintenance.');
    }

    /**
     * Status bijwerken (Maintenance)
     */
    public function updateStatus(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $maintenanceRequest->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status bijgewerkt.');
    }

    /**
     * Detail
     */
    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load([
            'customer',
            'contract',
            'product',
            'customer.creator',
        ]);

        return view('maintenance.requests.show', compact('maintenanceRequest'));
    }
}
