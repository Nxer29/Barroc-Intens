<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Contract;
use Illuminate\Http\Request;

class InvoiceOverviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['customer', 'contract']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->customer . '%');
            });
        }

        if ($request->filled('contract')) {
            $query->where('contract_id', $request->contract);
        }

        $invoices  = $query->paginate(15);
        $contracts = Contract::all();

        return view('invoices.overview', compact('invoices', 'contracts'));
    }
}