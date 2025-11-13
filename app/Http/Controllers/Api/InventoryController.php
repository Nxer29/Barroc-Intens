<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return Inventory::with(['product.category'])
            ->orderBy('product_id')
            ->paginate();
    }

    public function show(Inventory $inventory)
    {
        return $inventory->load('product.category');
    }

    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'min_threshold' => 'sometimes|integer|min:0',
            'location'      => 'sometimes|nullable|string|max:255',
        ]);

        $inventory->fill($data);
        $inventory->updated_at = now();
        $inventory->save();

        return $inventory->load('product.category');
    }

    public function changeStock(
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
            $request->user()?->id,
            $data['location'] ?? null
        );

        return $inventory->load('product.category');
    }
}
