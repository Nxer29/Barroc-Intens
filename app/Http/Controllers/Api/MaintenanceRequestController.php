<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{
    public function index(){ return MaintenanceRequest::with('appointments')->paginate(); }
    public function store(Request $request){ return MaintenanceRequest::create($request->all()); }
    public function show(MaintenanceRequest $maintenance_request){ return $maintenance_request->load('appointments'); }
    public function update(Request $request, MaintenanceRequest $maintenance_request){ $maintenance_request->update($request->all()); return $maintenance_request; }
    public function destroy(MaintenanceRequest $maintenance_request){ $maintenance_request->delete(); return response()->noContent(); }
}
