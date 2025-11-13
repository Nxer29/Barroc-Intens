<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(){ return Contract::with('lines')->paginate(); }
    public function store(Request $request){ return Contract::create($request->all()); }
    public function show(Contract $contract){ return $contract->load('lines'); }
    public function update(Request $request, Contract $contract){ $contract->update($request->all()); return $contract; }
    public function destroy(Contract $contract){ $contract->delete(); return response()->noContent(); }
}
