<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(){ return Quote::with('items')->paginate(); }
    public function store(Request $request){ return Quote::create($request->all()); }
    public function show(Quote $quote){ return $quote->load('items'); }
    public function update(Request $request, Quote $quote){ $quote->update($request->all()); return $quote; }
    public function destroy(Quote $quote){ $quote->delete(); return response()->noContent(); }
}
