<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryUIController extends Controller
{
    /**
     * 📦 Voorraadoverzicht
     */
    public function index()
    {
        $products = Product::with(['category', 'inventory'])
            ->orderBy('name')
            ->paginate(15);

        return view('inventory.index', compact('products'));
    }
    /**
     * 🔍 Detailpagina voorraad
     */
    public function show(Inventory $inventory)
    {
        $inventory->load('product.category');

        return view('inventory.show', compact('inventory'));
    }

    /**
     * ✏️ Voorraadinstellingen bewerken (threshold + locatie)
     */
    public function edit(Inventory $inventory)
    {
        $inventory->load('product');

        return view('inventory.edit', compact('inventory'));
    }

    /**
     * 💾 Bijwerken van threshold / locatie
     */
    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'min_threshold' => 'required|integer|min:0',
            'location'      => 'nullable|string|max:255',
        ]);

        $inventory->update([
            'min_threshold' => $data['min_threshold'],
            'location'      => $data['location'] ?? null,
            'updated_at'    => now(),
        ]);

        return redirect()
            ->route('inventory.show', $inventory)
            ->with('success', 'Voorraaddrempel succesvol bijgewerkt.');
    }

    /**
     * ➕➖ Voorraad aanpassen formulier
     */
    public function changeStock(Product $product)
    {
        $product->load(['category', 'inventory']);

        return view('inventory.change-stock', [
            'product' => $product,
        ]);
    }

    /**
     * 📥 Verwerking van voorraadwijziging
     */
    public function changeStockPost(
        Request $request,
        Product $product,
        InventoryService $inventoryService
    ) {
        $data = $request->validate([
            'change'   => 'required|integer',
            'reason'   => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $inventory = $inventoryService->changeStock(
            $product,
            $data['change'],
            $data['reason'] ?? null,
            $request->user()->id,
            $data['location'] ?? null
        );

        return redirect()
            ->route('inventory.show', $inventory)
            ->with('success', 'Voorraad succesvol aangepast.');
    }
}
