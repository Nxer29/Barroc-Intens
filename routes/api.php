<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{CustomerController, ProductController, QuoteController, ContractController, InvoiceController, MaintenanceRequestController};

Route::apiResource('customers', CustomerController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('quotes', QuoteController::class);
Route::apiResource('contracts', ContractController::class);
Route::apiResource('invoices', InvoiceController::class);
Route::apiResource('maintenance-requests', MaintenanceRequestController::class);

Route::get('health', fn() => ['ok' => true]);
