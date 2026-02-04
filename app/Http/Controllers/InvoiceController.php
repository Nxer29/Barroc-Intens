<?php

namespace App\Http\Controllers;

use App\Mail\InvoicePdfMail;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'status' => ['required', 'in:concept,onbetald,betaald'],
        ]);

        $invoice->status = $data['status'];
        $invoice->save();

        return back()->with('success', 'Factuurstatus aangepast.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()
            ->route('invoices.overview')
            ->with('success', 'Factuur verwijderd.');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load(['customer', 'lines']);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('factuur-' . $invoice->invoice_number . '.pdf');
    }

    public function sendPdf(Invoice $invoice)
    {
        $invoice->load(['customer', 'lines']);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        Mail::to($invoice->customer->contact_email)
            ->send(new InvoicePdfMail($invoice, $pdf->output()));

        return back()->with('success', 'Factuur per e-mail verstuurd.');
    }
}