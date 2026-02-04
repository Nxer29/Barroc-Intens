<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Customer;
use App\Models\User;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentUIController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['customer', 'type', 'technician'])
            ->orderBy('scheduled_at', 'desc')
            ->paginate(15);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $types = AppointmentType::all();

        $customers = Customer::orderBy('company_name')
                             ->orderBy('contact_name')
                             ->get();

        // Geen rollen → toon alle gebruikers als monteurs
        $technicians = User::all();

        return view('appointments.create', compact('types', 'customers', 'technicians'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'type_id'       => 'required|exists:appointment_types,id',
            'technician_id' => 'nullable|exists:users,id',
            'scheduled_at'  => 'required|date',
            'notes'         => 'nullable|string|max:2000',
            'status'        => 'nullable|string',
        ]);

        Appointment::create($data);

        return redirect()->route('appointments.index')
            ->with('success', 'Afspraak aangemaakt.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load([
            'customer.contracts',
            'customer.addresses',
            'type',
            'technician'
        ]);

        $scheduled = Carbon::parse($appointment->scheduled_at);

        // 1) Probeer een maintenance request te vinden die bij deze afspraak past
        // (zelfde klant + scheduled_at in de buurt + (optioneel) dezelfde monteur)
        $maintenanceRequest = MaintenanceRequest::with(['product', 'contract'])
            ->where('customer_id', $appointment->customer_id)
            ->whereNotNull('scheduled_at')
            ->when($appointment->technician_id, function ($q) use ($appointment) {
                $q->where('assigned_to', $appointment->technician_id);
            })
            ->whereBetween('scheduled_at', [
                $scheduled->copy()->subHours(4),
                $scheduled->copy()->addHours(4),
            ])
            ->orderByDesc('scheduled_at')
            ->first();

        // 2) Contract referentie bepalen:
        // - als maintenance request een contract heeft -> die gebruiken
        // - anders -> laatste actieve contract van klant
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

                // fallback: als er geen actieve is, pak de meest recente
                if (!$activeContract) {
                    $activeContract = $customer->contracts()
                        ->with('products')
                        ->orderByDesc('start_date')
                        ->first();
                }
            }
        }

        return view('appointments.show', compact('appointment', 'maintenanceRequest', 'activeContract'));
    }

    public function edit(Appointment $appointment)
    {
        $types = AppointmentType::all();

        $customers = Customer::orderBy('company_name')
                             ->orderBy('contact_name')
                             ->get();

        // Geen rollen → toon alle gebruikers
        $technicians = User::all();

        $appointment->load(['customer', 'type', 'technician']);

        return view('appointments.edit', compact('appointment', 'types', 'customers', 'technicians'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'type_id'       => 'required|exists:appointment_types,id',
            'technician_id' => 'nullable|exists:users,id',
            'scheduled_at'  => 'required|date',
            'status'        => 'nullable|string',
            'notes'         => 'nullable|string|max:2000',
        ]);

        $appointment->update($data);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Afspraak bijgewerkt.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Afspraak verwijderd.');
    }
}
