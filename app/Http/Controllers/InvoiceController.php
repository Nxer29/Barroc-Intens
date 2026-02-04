<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function create()
    {
        $customers = Customer::orderBy('company_name')->get();
        $products = Product::orderBy('name')->get();

        return view('invoices.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'issue_date'  => ['required', 'date'],
            'omschrijving'=> ['required', 'string', 'max:255'],
            'lines'       => ['required', 'array', 'min:1'],
            'lines.*.product_id' => ['required', 'exists:products,id'],
            'lines.*.quantity'   => ['required', 'integer', 'min:1'],
        ]);

        $total = 0;

        foreach ($validated['lines'] as $line) {
            $product = Product::findOrFail($line['product_id']);
            $total += $product->price * $line['quantity'];
        }

        $btw = round($total * 0.21, 2);
        $totaal = round($total + $btw, 2);

        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5)),
            'customer_id'    => $validated['customer_id'],
            'issue_date'     => $validated['issue_date'],
            'omschrijving'   => $validated['omschrijving'],
            'total_amount'   => $totaal,
            'status'         => 'concept',
        ]);

        foreach ($validated['lines'] as $line) {
            $product = Product::findOrFail($line['product_id']);
            $lineTotal = $product->price * $line['quantity'];

            InvoiceLine::create([
                'invoice_id'  => $invoice->id,
                'product_id'  => $product->id,
                'description' => $product->name,
                'quantity'    => $line['quantity'],
                'unit_price'  => $product->price,
                'line_total'  => $lineTotal,
            ]);
        }

        return redirect()
            ->route('invoices.overview')
            ->with('success', 'Factuur opgeslagen.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'lines']);

        return view('invoices.show', compact('invoice'));
    }
}