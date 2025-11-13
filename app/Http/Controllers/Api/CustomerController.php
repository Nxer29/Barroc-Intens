<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){ return Customer::with(['invoiceAddress','deliveryAddress'])->paginate(); }
    public function store(Request $request){ return Customer::create($request->all()); }
    public function show(Customer $customer){ return $customer->load(['invoiceAddress','deliveryAddress']); }
    public function update(Request $request, Customer $customer){ $customer->update($request->all()); return $customer; }
    public function destroy(Customer $customer){ $customer->delete(); return response()->noContent(); }
}
