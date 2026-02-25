<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\ProfileController;
use \App\Http\Controllers\AdminController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryUIController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AppointmentUIController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerNoteController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\QuoteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🚪 Login redirect
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// 🔐 Alleen voor ingelogde gebruikers


Route::group(['middleware' => ['role:Admin']], function () {
    Route::get('/admin-dashboard/users', [AdminController::class, 'users'])->name('admin-dashboard.users');
    Route::resource('admin-dashboard', AdminController::class);
    Route::post('/admin/users/roles/{id}', [AdminController::class, 'toggleRole']);
});
// ============================
// 🏠 Dashboard
// ============================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


// ============================
// 📦 Producten
// ============================
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/create', [ProductController::class, 'create'])
    ->name('products.create');

Route::post('/products', [ProductController::class, 'store'])
    ->name('products.store');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->whereNumber('product')
    ->name('products.show');

Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
    ->whereNumber('product')
    ->name('products.edit');

Route::put('/products/{product}', [ProductController::class, 'update'])
    ->whereNumber('product')
    ->name('products.update');

Route::delete('/products/{product}', [ProductController::class, 'destroy'])
    ->whereNumber('product')
    ->name('products.destroy');


// ============================
// 📚 Styleguide (Story 1.2)
// ============================
Route::view('/styleguide', 'pages.styleguide')
    ->name('styleguide');


// ============================
// 👤 Profiel
// ============================
Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');

Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');

// ============================
// 🧑‍💼 Klantenbeheer
// ============================
Route::get('/customers/index', [CustomerController::class, 'index'])
    ->name('customers.index');

Route::get('/customers/create', [CustomerController::class, 'create'])
    ->name('customers.create');

Route::post('/customers', [CustomerController::class, 'store'])
    ->name('customers.store');

Route::get('/customers/{customer}', [CustomerController::class, 'show'])
    ->whereNumber('customer')
    ->name('customers.show');


// ============================
// 📄 Contracten
// ============================
Route::resource('contracts', ContractController::class);


// ============================
// 📦 Voorraadbeheer (Inventory UI)
// ============================
Route::get('/inventory', [InventoryUIController::class, 'index'])
    ->name('inventory.index');

Route::get('/inventory/{inventory}', [InventoryUIController::class, 'show'])
    ->whereNumber('inventory')
    ->name('inventory.show');

Route::get('notes', [NotesController::class, 'index'])->name('notes.index');
Route::post('notes', [NotesController::class, 'store'])->name('notes.store');

Route::get('/inventory/{inventory}/edit', [InventoryUIController::class, 'edit'])
    ->whereNumber('inventory')
    ->name('inventory.edit');

Route::put('/inventory/{inventory}', [InventoryUIController::class, 'update'])
    ->whereNumber('inventory')
    ->name('inventory.update');

// wijzig voorraad (custom)
Route::get('/inventory/change/{product}', [InventoryUIController::class, 'changeStock'])
    ->whereNumber('product')
    ->name('inventory.change');

Route::post('/inventory/change/{product}', [InventoryUIController::class, 'changeStockPost'])
    ->whereNumber('product')
    ->name('inventory.change.post');


// ============================
// 🗓️ Planner — Afspraken (Appointments UI)
// ============================
Route::get('/appointments', [AppointmentUIController::class, 'index'])
    ->name('appointments.index');

Route::get('/appointments/create', [AppointmentUIController::class, 'create'])
    ->name('appointments.create');

Route::post('/appointments', [AppointmentUIController::class, 'store'])
    ->name('appointments.store');

Route::get('/appointments/{appointment}', [AppointmentUIController::class, 'show'])
    ->whereNumber('appointment')
    ->name('appointments.show');

Route::get('/appointments/{appointment}/edit', [AppointmentUIController::class, 'edit'])
    ->whereNumber('appointment')
    ->name('appointments.edit');

Route::patch('/appointments/{appointment}', [AppointmentUIController::class, 'update'])
    ->whereNumber('appointment')
    ->name('appointments.update');

Route::delete('/appointments/{appointment}', [AppointmentUIController::class, 'destroy'])
    ->whereNumber('appointment')
    ->name('appointments.destroy');

// ============================
// � Monteur Kalender (Tablet 8-inch)
// ============================
Route::middleware(['auth'])->group(function () {
    Route::get('/calendar/day', [CalendarController::class, 'day'])
        ->name('calendar.day');

    Route::get('/calendar/week', [CalendarController::class, 'week'])
        ->name('calendar.week');

    Route::get('/calendar/appointment/{appointment}', [CalendarController::class, 'appointmentDetails'])
        ->whereNumber('appointment')
        ->name('calendar.appointment-details');
});

// ============================
// �🗒️ Facturen (Invoices)
// ============================
Route::get('/invoices/overview', [App\Http\Controllers\InvoiceOverviewController::class, 'index'])->name('invoices.overview');
Route::get('/facturen/nieuw', [InvoiceController::class, 'create'])->name('invoices.create');
Route::post('/facturen', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/facturen/{invoice}', [InvoiceController::class, 'show'])
    ->whereNumber('invoice')
    ->name('invoices.show');
Route::patch('/facturen/{invoice}/status', [InvoiceController::class, 'updateStatus'])
    ->whereNumber('invoice')
    ->name('invoices.status');

Route::delete('/facturen/{invoice}', [InvoiceController::class, 'destroy'])
    ->whereNumber('invoice')
    ->name('invoices.destroy');

Route::get('/facturen/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])
    ->whereNumber('invoice')
    ->name('invoices.pdf');

Route::post('/facturen/{invoice}/send', [InvoiceController::class, 'sendPdf'])
    ->whereNumber('invoice')
    ->name('invoices.send');
// ============================
//  Maintenance – Storingsaanvragen
// ============================

// Overzicht (Maintenance queue)
Route::get('/maintenance/requests', [MaintenanceRequestController::class, 'index'])
    ->name('maintenance.requests.index');

// Aanmaken (Sales → Maintenance)
Route::get('/maintenance/requests/create/{customer}', [MaintenanceRequestController::class, 'create'])
    ->whereNumber('customer')
    ->name('maintenance.requests.create');

Route::post('/maintenance/requests', [MaintenanceRequestController::class, 'store'])
    ->name('maintenance.requests.store');

// Detail (later uitbreiden)
Route::get('/maintenance/requests/{maintenanceRequest}', [MaintenanceRequestController::class, 'show'])
    ->whereNumber('maintenanceRequest')
    ->name('maintenance.requests.show');
Route::patch(
    '/maintenance/requests/{maintenanceRequest}/status',
    [MaintenanceRequestController::class, 'updateStatus']
)->name('maintenance.requests.status');


Route::put('customers/{customer}/notes/{note}', [NotesController::class, 'update'])
    ->name('customers.notes.update');

Route::get('/customers/{customer}/edit', function (Customer $customer) {
    return view('customers.edit', compact('customer'));
})->name('customers.edit');

Route::put('/customers/{customer}', function (Request $request, Customer $customer) {
    $data = $request->validate([
        'company_name'   => 'required|string|max:255',
        'contact_name'   => 'nullable|string|max:255',
        'contact_email'  => 'nullable|email|max:255',
        'contact_phone'  => 'nullable|string|max:50',
        'status'         => 'nullable|string|max:50',
    ]);

    $customer->company_name = $data['company_name'];
    $customer->contact_name = $data['contact_name'] ?? null;
    $customer->contact_email = $data['contact_email'] ?? null;
    $customer->contact_phone = $data['contact_phone'] ?? null;
    $customer->status = $data['status'] ?? $customer->status;
    $customer->save();

    return redirect()->route('customers.index')->with('success', 'Klant bijgewerkt.');
})->name('customers.update');

Route::middleware(['auth'])->group(function () {
    // ...
    Route::resource('quotes', QuoteController::class);
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.overview');
    Route::get('quotes/{quote}/pdf', [QuoteController::class, 'pdf'])->name('quotes.pdf');
    Route::post('quotes/{quote}/email', [QuoteController::class, 'email'])->name('quotes.email');
    Route::post('quotes/{quote}/send', [QuoteController::class, 'send'])->name('quotes.send');
});

require __DIR__ . '/auth.php';