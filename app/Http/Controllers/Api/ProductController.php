<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){ return Product::with('category')->paginate(); }
    public function store(Request $request){ return Product::create($request->all()); }
    public function show(Product $product){ return $product->load('category'); }
    public function update(Request $request, Product $product){ $product->update($request->all()); return $product; }
    public function destroy(Product $product){ $product->delete(); return response()->noContent(); }
}
