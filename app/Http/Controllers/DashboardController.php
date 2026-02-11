<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Contract;
use App\Models\Inventory;
use App\Models\Appointment;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Bepaal de rol
        if ($user->hasRole('Admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('sales')) {
            return $this->salesDashboard();
        } elseif ($user->hasRole('finance')) {
            return $this->financeDashboard();
        } elseif ($user->hasRole('inkoop')) {
            return $this->inkoopDashboard();
        } elseif ($user->hasRole('maintenance')) {
            return $this->maintenanceDashboard($user);
        }

        return view('dashboard', [
            'widgets' => [],
            'activityData' => json_encode([0, 0, 0, 0, 0, 0, 0]),
            'appointmentsToday' => 0,
            'openTasks' => 0,
            'newMessages' => 0,
            'recentActivity' => collect()
        ]);
    }

    private function adminDashboard()
    {
        $widgets = [
            ['title' => 'Klanten', 'value' => Customer::count(), 'route' => 'customers.index'],
            ['title' => 'Contracten', 'value' => Contract::count(), 'route' => 'contracts.index'],
            ['title' => 'Afspraken', 'value' => Appointment::count(), 'route' => 'appointments.index'],
            ['title' => 'Producten', 'value' => Product::count(), 'route' => 'products.index'],
        ];

        $activityData = json_encode($this->getActivityData());
        $appointmentsToday = Appointment::whereDate('scheduled_at', Carbon::today())->count();
        $openTasks = Appointment::where('status', 'planned')->count();
        $recentActivity = $this->getRecentActivity();

        return view('dashboard', compact('widgets', 'activityData', 'appointmentsToday', 'openTasks', 'recentActivity'))->with('newMessages', 0);
    }

    private function salesDashboard()
    {
        $widgets = [
            ['title' => 'Klanten', 'value' => Customer::count(), 'route' => 'customers.index'],
            ['title' => 'Contracten', 'value' => Contract::count(), 'route' => 'contracts.index'],
            ['title' => 'Afspraken', 'value' => Appointment::count(), 'route' => 'appointments.index'],
            ['title' => 'Actieve deals', 'value' => Contract::where('status', 'active')->count(), 'route' => 'contracts.index'],
        ];

        $activityData = json_encode($this->getActivityData());
        $appointmentsToday = Appointment::whereDate('scheduled_at', Carbon::today())->count();
        $openTasks = Appointment::where('status', 'planned')->count();
        $recentActivity = $this->getRecentActivity();

        return view('dashboard', compact('widgets', 'activityData', 'appointmentsToday', 'openTasks', 'recentActivity'))->with('newMessages', 0);
    }

    private function financeDashboard()
    {
        $widgets = [
            ['title' => 'Contracten', 'value' => Contract::count(), 'route' => 'contracts.index'],
            ['title' => 'Actieve contracten', 'value' => Contract::where('status', 'active')->count(), 'route' => 'contracts.index'],
            ['title' => 'Klanten', 'value' => Customer::count(), 'route' => 'customers.index'],
            ['title' => 'Afspraken', 'value' => Appointment::count(), 'route' => 'appointments.index'],
        ];

        $activityData = json_encode($this->getActivityData());
        $appointmentsToday = Appointment::whereDate('scheduled_at', Carbon::today())->count();
        $openTasks = Appointment::where('status', 'planned')->count();
        $recentActivity = $this->getRecentActivity();

        return view('dashboard', compact('widgets', 'activityData', 'appointmentsToday', 'openTasks', 'recentActivity'))->with('newMessages', 0);
    }

    private function inkoopDashboard()
    {
        $widgets = [
            ['title' => 'Voorraaditems', 'value' => Inventory::count(), 'route' => 'inventory.index'],
            ['title' => 'Producten', 'value' => Product::count(), 'route' => 'products.index'],
            ['title' => 'Lage voorraad', 'value' => Inventory::where('quantity', '<', 10)->count(), 'route' => 'inventory.index'],
            ['title' => 'Categorieën', 'value' => Product::distinct('category')->count(), 'route' => 'products.index'],
        ];

        $activityData = json_encode([0, 0, 0, 0, 0, 0, 0]);
        $appointmentsToday = 0;
        $openTasks = 0;
        $recentActivity = collect();

        return view('dashboard', compact('widgets', 'activityData', 'appointmentsToday', 'openTasks', 'recentActivity'))->with('newMessages', 0);
    }

    private function maintenanceDashboard($user)
    {
        $widgets = [
            ['title' => 'Mijn afspraken', 'value' => Appointment::where('technician_id', $user->id)->count(), 'route' => 'appointments.index'],
            ['title' => 'Geplande taken', 'value' => Appointment::where('technician_id', $user->id)->where('status', 'planned')->count(), 'route' => 'appointments.index'],
            ['title' => 'Voltooid', 'value' => Appointment::where('technician_id', $user->id)->where('status', 'completed')->count(), 'route' => 'appointments.index'],
            ['title' => 'Klanten', 'value' => Appointment::where('technician_id', $user->id)->distinct('customer_id')->count('customer_id'), 'route' => null],
        ];

        $activityData = json_encode($this->getActivityDataForTechnician($user->id));
        $appointmentsToday = Appointment::where('technician_id', $user->id)->whereDate('scheduled_at', Carbon::today())->count();
        $openTasks = Appointment::where('technician_id', $user->id)->where('status', 'planned')->count();
        $recentActivity = $this->getRecentActivityForTechnician($user->id);

        return view('dashboard', compact('widgets', 'activityData', 'appointmentsToday', 'openTasks', 'recentActivity'))->with('newMessages', 0);
    }

    private function getActivityData()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $data[] = Appointment::whereDate('scheduled_at', $date)->count();
        }
        return $data;
    }

    private function getActivityDataForTechnician($technicianId)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $data[] = Appointment::where('technician_id', $technicianId)->whereDate('scheduled_at', $date)->count();
        }
        return $data;
    }

    private function getRecentActivity()
    {
        return Appointment::with('customer', 'type')
            ->latest('created_at')
            ->limit(3)
            ->get()
            ->map(function ($apt) {
                return [
                    'type' => 'Afspraak aangemaakt',
                    'title' => $apt->customer->company_name ?? 'Onbekend',
                    'time' => $apt->created_at->diffForHumans(),
                    'color' => 'yellow',
                ];
            });
    }

    private function getRecentActivityForTechnician($technicianId)
    {
        return Appointment::where('technician_id', $technicianId)
            ->with('customer', 'type')
            ->latest('created_at')
            ->limit(3)
            ->get()
            ->map(function ($apt) {
                return [
                    'type' => $apt->type->name ?? 'Afspraak',
                    'title' => $apt->customer->company_name ?? 'Onbekend',
                    'time' => $apt->created_at->diffForHumans(),
                    'color' => $apt->status === 'completed' ? 'emerald' : 'yellow',
                ];
            });
    }
}
