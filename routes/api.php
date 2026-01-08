<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    CustomerController,
    ProductController,
    QuoteController,
    ContractController,
    InvoiceController,
    MaintenanceRequestController,
};
use App\Http\Controllers\Api\InventoryController;

Route::apiResource('customers', CustomerController::class);

// Products are publicly readable, but hidden products are excluded by default.
// Use ?include_hidden=1 for administrative usage.
Route::apiResource('products', ProductController::class);

Route::apiResource('quotes', QuoteController::class);
Route::apiResource('contracts', ContractController::class);
Route::apiResource('invoices', InvoiceController::class);
Route::apiResource('maintenance-requests', MaintenanceRequestController::class);

Route::apiResource('inventory', InventoryController::class)->only(['index', 'show', 'update']);
Route::post('products/{product}/inventory/change-stock', [InventoryController::class, 'changeStock']);

Route::get('health', fn () => ['ok' => true]);
