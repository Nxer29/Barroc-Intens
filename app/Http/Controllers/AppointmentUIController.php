<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

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
        $appointment->load(['customer', 'type', 'technician']);
        return view('appointments.show', compact('appointment'));
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
