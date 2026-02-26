<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Day view - shows appointments for a specific day
     */
    public function day(Request $request)
    {
        $dateString = $request->query('date', now()->toDateString());
        $date = Carbon::createFromFormat('Y-m-d', $dateString)->startOfDay();

        // Get logged-in user (monteur/technician)
        $user = Auth::user();

        // Get appointments for this technician on this day
        $appointments = Appointment::where('technician_id', $user->id)
            ->whereDate('scheduled_at', $date)
            ->with(['customer', 'type', 'technician'])
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $previousDate = $date->copy()->subDay();
        $nextDate = $date->copy()->addDay();

        return view('calendar.monteur.day', compact('date', 'appointments', 'previousDate', 'nextDate'));
    }

    /**
     * Week view - shows appointments for a specific week
     */
    public function week(Request $request)
    {
        $dateString = $request->query('date', now()->toDateString());
        $date = Carbon::createFromFormat('Y-m-d', $dateString);

        // Get start of week (Monday)
        $weekStart = $date->copy()->startOfWeek();
        $weekEnd = $date->copy()->endOfWeek();

        // Get logged-in user (monteur/technician)
        $user = Auth::user();

        // Get all appointments for this technician this week
        $appointments = Appointment::where('technician_id', $user->id)
            ->whereBetween('scheduled_at', [$weekStart, $weekEnd])
            ->with(['customer', 'type', 'technician'])
            ->orderBy('scheduled_at', 'asc')
            ->get();

        // Group by date for easier rendering
        $appointmentsByDay = collect();
        for ($i = 0; $i < 7; $i++) {
            $day = $weekStart->copy()->addDays($i);
            $dayAppointments = $appointments->filter(function ($apt) use ($day) {
                return $apt->scheduled_at->toDateString() === $day->toDateString();
            });
            $appointmentsByDay[$day->toDateString()] = $dayAppointments;
        }

        $previousWeekStart = $weekStart->copy()->subWeek();
        $nextWeekStart = $weekStart->copy()->addWeek();

        return view('calendar.monteur.week', compact(
            'weekStart',
            'weekEnd',
            'appointments',
            'appointmentsByDay',
            'previousWeekStart',
            'nextWeekStart'
        ));
    }

    /**
     * Get appointment details as JSON (for modal/AJAX)
     */
    public function appointmentDetails(Request $request, Appointment $appointment)
    {
        // Ensure user can only see their own appointments
        if ($appointment->technician_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Load relations including work order and materials
        $appointment->load([
            'customer.contracts.products',
            'type',
            'technician'
        ]);

        // Load WorkOrder if exists
        $workOrder = \App\Models\WorkOrder::where('appointment_id', $appointment->id)
            ->with(['materials.product'])
            ->first();

        // Find related maintenance request
        $maintenanceRequest = MaintenanceRequest::with(['product', 'contract.products'])
            ->where('customer_id', $appointment->customer_id)
            ->whereNotNull('scheduled_at')
            ->when($appointment->technician_id, function ($q) use ($appointment) {
                $q->where('assigned_to', $appointment->technician_id);
            })
            ->whereBetween('scheduled_at', [
                $appointment->scheduled_at->copy()->subHours(4),
                $appointment->scheduled_at->copy()->addHours(4),
            ])
            ->orderByDesc('scheduled_at')
            ->first();

        // Get contract
        $activeContract = null;
        if ($maintenanceRequest && $maintenanceRequest->contract) {
            $activeContract = $maintenanceRequest->contract->load('products');
        } else {
            $customer = $appointment->customer;
            if ($customer) {
                $activeContract = $customer->contracts()
                    ->with('products')
                    ->where('status', 'active')
                    ->orderByDesc('start_date')
                    ->first();

                if (!$activeContract) {
                    $activeContract = $customer->contracts()
                        ->with('products')
                        ->orderByDesc('start_date')
                        ->first();
                }
            }
        }

        // Get customer address (invoice or delivery address)
        $address = null;
        if ($appointment->customer) {
            if ($appointment->customer->delivery_address_id) {
                $address = \App\Models\Address::find($appointment->customer->delivery_address_id);
            } elseif ($appointment->customer->invoice_address_id) {
                $address = \App\Models\Address::find($appointment->customer->invoice_address_id);
            }
        }

        // Build response
        return response()->json([
            'id' => $appointment->id,
            'scheduled_at' => $appointment->scheduled_at->toIso8601String(),
            'status' => $appointment->status,
            'notes' => $appointment->notes,
            'type' => $appointment->type ? $appointment->type->name : 'Onbekend',

            'customer' => [
                'id' => $appointment->customer->id ?? null,
                'name' => $appointment->customer->company_name ?? 'Onbekende klant',
                'contact_name' => $appointment->customer->contact_name ?? '',
                'contact_email' => $appointment->customer->contact_email ?? '',
                'contact_phone' => $appointment->customer->contact_phone ?? '',
            ],

            'address' => $address ? [
                'street' => $address->street,
                'city' => $address->city,
                'postal_code' => $address->postal_code,
                'country' => $address->country,
            ] : null,

            // Probleemomschrijving + referentie storingsaanvraag
            'maintenance_request' => $maintenanceRequest ? [
                'id' => $maintenanceRequest->id,
                'request_number' => $maintenanceRequest->request_number,
                'issue_description' => $maintenanceRequest->issue_description,
                'urgency' => $maintenanceRequest->urgency,
                'priority' => $maintenanceRequest->priority,
                'product' => $maintenanceRequest->product ? [
                    'id' => $maintenanceRequest->product->id,
                    'name' => $maintenanceRequest->product->name,
                ] : null,
            ] : null,

            // Contractreferentie + “benodigde spullen” (producten met aantallen)
            'contract' => $activeContract ? [
                'id' => $activeContract->id,
                'name' => $activeContract->name,
                'status' => $activeContract->status,
                'start_date' => $activeContract->start_date?->toDateString(),
                'end_date' => $activeContract->end_date?->toDateString(),
                'products' => $activeContract->products->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'quantity' => (int)($p->pivot->quantity ?? 1),
                    'unit_price' => $p->pivot->unit_price,
                ])->values(),
            ] : null,

            'materials_used' => $workOrder ? $workOrder->materials->map(fn($m) => [
                'id' => $m->id,
                'product_id' => $m->product_id,
                'product_name' => $m->product?->name ?? 'Onbekend product',
                'quantity' => $m->quantity,
                'unit_price' => $m->unit_price,
            ])->values() : null,

            'work_order' => $workOrder ? [
                'id' => $workOrder->id,
                'notes' => $workOrder->notes,
                'performed_by' => \App\Models\User::find($workOrder->performed_by)?->name,
            ] : null,
        ]);
    }
}
