<?php

namespace App\Observers;

use App\Models\MaterialsUsed;
use App\Models\Notification;
use App\Models\User;
use App\Services\InventoryService;
use Illuminate\Support\Facades\DB;

class MaterialsUsedObserver
{
    /**
     * Wanneer maintenance materialen registreert op een werkbon,
     * maken we automatisch een stock_movement aan én sturen we een notificatie naar Inkoop.
     */
    public function created(MaterialsUsed $materialsUsed): void
    {
        // Alleen wanneer er daadwerkelijk een product is geregistreerd
        if (!$materialsUsed->product_id) {
            return;
        }

        DB::transaction(function () use ($materialsUsed) {
            $workOrder = $materialsUsed->workOrder()->first();
            $product   = $materialsUsed->product()->first();

            if (!$workOrder || !$product) {
                return;
            }

            // 1) Voorraad afboeken + stock_movement loggen (negatief, want materiaal is gebruikt)
            app(InventoryService::class)->changeStock(
                $product,
                -1 * (int) $materialsUsed->quantity,
                'Used in work order #' . $workOrder->id,
                $workOrder->performed_by,
                null,
                'work_order',
                (int) $workOrder->id
            );

            // 2) Notificatie naar Inkoop (rol: inkoop)
            $inkoopUsers = User::role('inkoop')->get(); // Spatie permission

            foreach ($inkoopUsers as $user) {
                Notification::create([
                    'user_id'    => $user->id,
                    'type'       => 'workorder.material_used',
                    'payload'    => json_encode([
                        'work_order_id' => $workOrder->id,
                        'product_id'    => $product->id,
                        'product_name'  => $product->name,
                        'quantity'      => (int) $materialsUsed->quantity,
                    ]),
                    'is_read'    => false,
                    'created_at' => now(),
                ]);
            }
        });
    }
}
