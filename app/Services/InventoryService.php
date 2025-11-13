<?php
namespace App\Services;

use App\Models\Inventory;
use App\Models\Notification;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function changeStock(
        Product $product,
        int $change,
        ?string $reason = null,
        ?int $performedByUserId = null,
        ?string $location = null
    ): Inventory {
        return DB::transaction(function () use ($product, $change, $reason, $performedByUserId, $location) {
            $inventory = Inventory::firstOrCreate(
                [
                    'product_id' => $product->id,
                    'location'   => $location,
                ],
                [
                    'quantity'      => 0,
                    'min_threshold' => 0,
                    'updated_at'    => now(),
                ]
            );

            $oldQuantity = $inventory->quantity;

            // voorraad aanpassen
            $inventory->quantity += $change;
            $inventory->updated_at = now();
            $inventory->save();

            // totale stock op product bijwerken
            $product->stock = Inventory::where('product_id', $product->id)->sum('quantity');
            $product->save();

            // mutatie loggen
            StockMovement::create([
                'product_id'     => $product->id,
                'change'         => $change,
                'reason'         => $reason,
                'reference_type' => null,
                'reference_id'   => null,
                'performed_by'   => $performedByUserId,
                'created_at'     => now(),
            ]);

            // check: van genoeg voorraad naar tekort
            if ($oldQuantity >= $inventory->min_threshold && $inventory->quantity < $inventory->min_threshold) {
                $this->createLowStockNotifications($product, $inventory);
            }

            return $inventory;
        });
    }

    protected function createLowStockNotifications(Product $product, Inventory $inventory): void
    {
        // kies rollen die meldingen moeten krijgen
        $users = User::whereHas('role', function ($q) {
            $q->whereIn('name', ['warehouse_manager', 'admin', 'manager']);
        })->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id'   => $user->id,
                'type'      => 'inventory.low_stock',
                'payload'   => json_encode([
                    'product_id'    => $product->id,
                    'product_name'  => $product->name,
                    'location'      => $inventory->location,
                    'quantity'      => $inventory->quantity,
                    'min_threshold' => $inventory->min_threshold,
                ]),
                'is_read'   => false,
                'created_at'=> now(),
            ]);
        }
    }
}
