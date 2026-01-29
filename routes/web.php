<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryUIController;
use App\Http\Controllers\CustomerController;
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
Route::middleware(['auth'])->group(function () {

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

    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->whereNumber('product')
        ->name('products.show');


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
    Route::get('/customers/create', [CustomerController::class, 'create'])
        ->name('customers.create');

    Route::post('/customers', [CustomerController::class, 'store'])
        ->name('customers.store');

    Route::get('/customers/{customer}', [CustomerController::class, 'show'])
        ->whereNumber('customer')
        ->name('customers.show');
    Route::resource('contracts', ContractController::class);


    Route::get('notes', [NotesController::class, 'index'])->name('notes.index');
    Route::post('notes', [NotesController::class, 'store'])->name('notes.store');


    
// Optional: route to update a customer's note (if you implemented it)
Route::put('customers/{customer}/notes/{note}', [NotesController::class, 'update'])
    ->name('customers.notes.update');

    Route::get('/invoices/overview', [App\Http\Controllers\InvoiceOverviewController::class, 'index'])->name('invoices.overview');
});

require __DIR__.'/auth.php';
