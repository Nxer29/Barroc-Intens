<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Contract;
use App\Models\Inventory;
use App\Models\Appointment;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $widgets = [];

        /*
        |--------------------------------------------------------------------------
        | ADMIN – ziet alles
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('Admin')) {
            $widgets = [

                // =========================
                // OVERZICHT (status)
                // =========================
                [
                    'title' => 'Klanten overzicht',
                    'value' => Customer::count(),
                    'route' => 'customers.index',
                ],
                [
                    'title' => 'Contracten',
                    'value' => Contract::count(),
                    'route' => 'contracts.index',
                ],
                [
                    'title' => 'Afspraken',
                    'value' => Appointment::count(),
                    'route' => 'appointments.index',
                ],
                [
                    'title' => 'Actieve afspraken',
                    'value' => Appointment::where('status', 'planned')->count(),
                    'route' => 'appointments.index',
                ],
                [
                    'title' => 'Factuuroverzicht',
                    'value' => '',
                    'route' => 'invoices.overview',
                ],

                // =========================
                // ACTIES (toevoegen)
                // =========================
                [
                    'title' => 'Nieuwe klant',
                    'value' => 'Toevoegen',
                    'route' => 'customers.create',
                ],
                [
                    'title' => 'Nieuw contract',
                    'value' => 'Aanmaken',
                    'route' => 'contracts.create',
                ],
                [
                    'title' => 'Nieuwe afspraak',
                    'value' => 'Inplannen',
                    'route' => 'appointments.create',
                ],

                // =========================
                // OPERATIONEEL
                // =========================
                [
                    'title' => 'Producten',
                    'value' => Product::count(),
                    'route' => 'products.index',
                ],
                [
                    'title' => 'Voorraaditems',
                    'value' => Inventory::count(),
                    'route' => 'inventory.index',
                ],
                [
                    'title' => 'Storingformulier',
                    'value' => '',
                    'route' => 'maintenance.requests.index',
                ],
                [
                    'title' => 'Notities',
                    'value' => 'Overzicht',
                    'route' => 'notes.index',
                ],

                // =========================
                // BEHEER
                // =========================
                [
                    'title' => 'Admin dashboard',
                    'value' => 'Beheer',
                    'route' => 'admin-dashboard.index',
                ],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SALES
        |--------------------------------------------------------------------------
        */
        elseif ($user->hasRole('sales')) {
            $widgets = [
                [
                    'title' => 'Klanten overzicht',
                    'value' => Customer::count(),
                    'route' => 'customers.index',
                ],
                [
                    'title' => 'Contracten',
                    'value' => Contract::count(),
                    'route' => 'contracts.index',
                ],
                [
                    'title' => 'Afspraken',
                    'value' => Appointment::count(),
                    'route' => 'appointments.index',
                ],
                [
                    'title' => 'Factuuroverzicht',
                    'value' => '',
                    'route' => 'invoices.overview',
                ],

                [
                    'title' => 'Nieuwe klant',
                    'value' => 'Toevoegen',
                    'route' => 'customers.create',
                ],
                [
                    'title' => 'Nieuw contract',
                    'value' => 'Aanmaken',
                    'route' => 'contracts.create',
                ],
                [
                    'title' => 'Nieuwe afspraak',
                    'value' => 'Inplannen',
                    'route' => 'appointments.create',
                ],

                [
                    'title' => 'Storingformulier',
                    'value' => '',
                    'route' => 'maintenance.requests.index',
                ],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | FINANCE
        |--------------------------------------------------------------------------
        */
        elseif ($user->hasRole('finance')) {
            $widgets = [
                [
                    'title' => 'Contracten',
                    'value' => Contract::count(),
                    'route' => 'contracts.index',
                ],
                [
                    'title' => 'Factuuroverzicht',
                    'value' => '',
                    'route' => 'invoices.overview',
                ],
                [
                    'title' => 'Actieve afspraken',
                    'value' => Appointment::where('status', 'planned')->count(),
                    'route' => 'appointments.index',
                ],
                [
                    'title' => 'Notities',
                    'value' => 'Overzicht',
                    'route' => 'notes.index',
                ],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | INKOOP
        |--------------------------------------------------------------------------
        */
        elseif ($user->hasRole('inkoop')) {
            $widgets = [
                [
                    'title' => 'Voorraaditems',
                    'value' => Inventory::count(),
                    'route' => 'inventory.index',
                ],
                [
                    'title' => 'Producten',
                    'value' => Product::count(),
                    'route' => 'products.index',
                ],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | MAINTENANCE
        |--------------------------------------------------------------------------
        */
        elseif ($user->hasRole('maintenance')) {
            $widgets = [
                [
                    'title' => 'Geplande afspraken',
                    'value' => Appointment::where('status', 'planned')->count(),
                    'route' => 'appointments.index',
                ],
                [
                    'title' => 'Alle afspraken',
                    'value' => 'Bekijken',
                    'route' => 'appointments.index',
                ],
                [
                    'title' => 'Storingformulier',
                    'value' => 'Bekijken',
                    'route' => 'maintenance.requests.index',
                ],
            ];
        }

        return view('dashboard', compact('widgets'));
    }
}
