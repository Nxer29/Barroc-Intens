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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerNoteController;
use App\Http\Controllers\NotesController;

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

    Route::get('/products/edit', [ProductController::class, 'edit'])
    ->name('products.edit');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
    ->name('products.edit');

    Route::patch('/products/{product}', [ProductController::class, 'edit'])
    ->name('products.edit');

    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->whereNumber('product')
        ->name('products.show');


    Route::patch('/products/{product}', [ProductController::class, 'edit'])
    ->name('products.edit');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
    ->name('products.edit');

    Route::delete('/products/{product}', [ProductController::class, 'destroy']);


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

    Route::get('/invoices/overview', [App\Http\Controllers\InvoiceOverviewController::class, 'index'])->name('invoices.overview');



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

require __DIR__.'/auth.php';
