<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(){ return Invoice::with('lines')->paginate(); }
    public function store(Request $request){ return Invoice::create($request->all()); }
    public function show(Invoice $invoice){ return $invoice->load('lines'); }
    public function update(Request $request, Invoice $invoice){ $invoice->update($request->all()); return $invoice; }
    public function destroy(Invoice $invoice){ $invoice->delete(); return response()->noContent(); }
}
