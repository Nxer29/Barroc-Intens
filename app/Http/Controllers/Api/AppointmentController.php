<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::with(['customer', 'type', 'technician'])
            ->orderBy('scheduled_at')
            ->paginate();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'type_id'       => 'required|exists:appointment_types,id',
            'technician_id' => 'nullable|exists:users,id',
            'scheduled_at'  => 'required|date',
            'notes'         => 'nullable|string',
        ]);

        $appointment = Appointment::create($data);

        // Placeholder: notificatie naar monteur
        // Notification::send($technician, new AppointmentAssigned($appointment));

        return $appointment->load('customer', 'type', 'technician');
    }

    public function show(Appointment $appointment)
    {
        return $appointment->load('customer', 'type', 'technician');
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'technician_id' => 'nullable|exists:users,id',
            'scheduled_at'  => 'nullable|date',
            'status'        => 'nullable|string',
            'notes'         => 'nullable|string',
        ]);

        $appointment->update($data);

        return $appointment->load('customer', 'type', 'technician');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(['success' => true]);
    }
}
