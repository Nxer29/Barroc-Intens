<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user()->role ?? 'Sales';

        $widgets = match($role) {
            'Finance' => [
                ['title' => 'Openstaande facturen', 'value' => '12'],
                ['title' => 'Onbetaalde bedragen', 'value' => '€4.830'],
            ],
            'Sales' => [
                ['title' => 'Leads vandaag', 'value' => '8'],
                ['title' => 'Offertes', 'value' => '3'],
            ],
            'Inkoop' => [
                ['title' => 'Producten bijna op', 'value' => '6'],
                ['title' => 'Bestellingen', 'value' => '2'],
            ],
            default => [
                ['title' => 'Taken', 'value' => '4'],
            ],
        };

        return view('dashboard', compact('role', 'widgets'));
    }
}
