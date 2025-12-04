<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Customer;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    // GET /notes - lijst + klant-selectie + formulier
    public function index(Request $request)
    {
        $customers = Customer::orderBy('company_name')->get();

        $query = Note::with(['customer', 'author'])->latest();

        // Haal query-parameter op (kan leeg zijn). Als customer_id niet leeg is en niet 'all',
        // filter dan op die klant. Als leeg of 'all' => toon alle notities.
        $customerId = $request->query('customer_id');

        if (!empty($customerId) && $customerId !== 'all') {
            $query->where('customer_id', $customerId);
        }

        $notes = $query->paginate(20)->withQueryString();

        return view('notes.index', compact('customers', 'notes'));
    }

    // POST /notes - opslaan
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'body' => 'required|string|max:5000',
        ]);

        $note = Note::create([
            'customer_id' => $data['customer_id'],
            'body' => $data['body'],
            'author_id' => $request->user()?->id,
        ]);

        return redirect()->route('notes.index', ['customer_id' => $data['customer_id']])
            ->with('success', 'Notitie toegevoegd.');
    }
}