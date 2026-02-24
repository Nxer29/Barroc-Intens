<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\QuotePdfMail;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::with('customer')->orderByDesc('created_at')->paginate(10);
        return view('quotes.index', compact('quotes'));
    }

    public function create()
    {
        $customers = Customer::orderBy('company_name')->get();
        $products = Product::orderBy('name')->get();
        return view('quotes.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required','exists:customers,id'],
            'valid_until' => ['nullable','date'],
            'status' => ['nullable','string'],
            'preferences' => ['nullable','string'],
            'machines_count' => ['nullable','integer','min:0'],
            'items' => ['required','array','min:1'],
            'items.*.product_id' => ['nullable','exists:products,id'],
            'items.*.description' => ['nullable','string'],
            'items.*.quantity' => ['required','integer','min:1'],
            'items.*.unit_price' => ['required','numeric','min:0'],
        ]);

        $quoteNumber = 'Q-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5));

        $quote = Quote::create([
            'quote_number' => $quoteNumber,
            'customer_id' => $data['customer_id'],
            'created_by' => Auth::id(),
            'created_at' => now(),
            'valid_until' => $data['valid_until'] ?? null,
            'status' => $data['status'] ?? 'draft',
            'preferences' => $data['preferences'] ?? null,
            'machines_count' => $data['machines_count'] ?? null,
            'total_amount' => 0,
        ]);

        $total = 0;

        foreach ($data['items'] as $item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];
            $total += $lineTotal;

            QuoteItem::create([
                'quote_id' => $quote->id,
                'product_id' => $item['product_id'] ?? null,
                'description' => $item['description'] ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'line_total' => $lineTotal,
            ]);
        }

        $quote->update(['total_amount' => $total]);

        return redirect()->route('quotes.show', $quote)->with('success', 'Offerte aangemaakt.');
    }

    public function show(Quote $quote)
    {
        $quote->load(['items', 'customer']);
        return view('quotes.show', compact('quote'));
    }

    public function edit(Quote $quote)
    {
        $customers = Customer::orderBy('company_name')->get();
        $products = Product::orderBy('name')->get();
        $quote->load('items');
        return view('quotes.edit', compact('quote', 'customers', 'products'));
    }

    public function update(Request $request, Quote $quote)
    {
        $data = $request->validate([
            'customer_id' => ['required','exists:customers,id'],
            'valid_until' => ['nullable','date'],
            'status' => ['nullable','string'],
            'preferences' => ['nullable','string'],
            'machines_count' => ['nullable','integer','min:0'],
            'items' => ['required','array','min:1'],
            'items.*.product_id' => ['nullable','exists:products,id'],
            'items.*.description' => ['nullable','string'],
            'items.*.quantity' => ['required','integer','min:1'],
            'items.*.unit_price' => ['required','numeric','min:0'],
        ]);

        $quote->update([
            'customer_id' => $data['customer_id'],
            'valid_until' => $data['valid_until'] ?? null,
            'status' => $data['status'] ?? $quote->status,
            'preferences' => $data['preferences'] ?? null,
            'machines_count' => $data['machines_count'] ?? null,
        ]);

        $quote->items()->delete();

        $total = 0;
        foreach ($data['items'] as $item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];
            $total += $lineTotal;

            QuoteItem::create([
                'quote_id' => $quote->id,
                'product_id' => $item['product_id'] ?? null,
                'description' => $item['description'] ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'line_total' => $lineTotal,
            ]);
        }

        $quote->update(['total_amount' => $total]);

        return redirect()->route('quotes.show', $quote)->with('success', 'Offerte bijgewerkt.');
    }

    public function pdf(Quote $quote)
    {
        $quote->load(['items', 'customer']);
        $pdf = Pdf::loadView('quotes.pdf', compact('quote'));
        return $pdf->download('offerte-'.$quote->quote_number.'.pdf');
    }

    public function email(Quote $quote)
    {
        $quote->load(['items', 'customer']);

        Mail::to($quote->customer->contact_email)
            ->send(new QuotePdfMail($quote));

        $quote->update(['status' => 'sent']);

        return redirect()->route('quotes.show', $quote)->with('success', 'Offerte is verstuurd.');
    }

    public function send(Quote $quote)
    {
        return $this->email($quote);
    }
}