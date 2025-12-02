<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // maak pivot-tabel aan als die nog niet bestaat
        if (! Schema::hasTable('contract_product')) {
            Schema::create('contract_product', function (Blueprint $table) {
                $table->id();
                // gebruik unsignedBigInteger zodat we foreign keys later veilig kunnen toevoegen
                $table->unsignedBigInteger('contract_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('quantity')->default(1);
                $table->decimal('unit_price', 12, 2)->nullable();
                $table->timestamps();

                $table->unique(['contract_id','product_id']);
            });

            // voeg foreign keys alleen toe als de doel-tabellen al bestaan
            if (Schema::hasTable('contracts') && Schema::hasTable('products')) {
                Schema::table('contract_product', function (Blueprint $table) {
                    $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
                    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                });
            }
        }
    }

    public function down(): void
    {
        // probeer eerst de foreign keys te droppen (als ze bestaan), daarna de tabel
        if (Schema::hasTable('contract_product')) {
            // droppen van foreign keys kan fout geven als ze niet bestaan, dus check of kolommen bestaan
            Schema::table('contract_product', function (Blueprint $table) {
                // Silently attempt to drop constraints if they exist (Laravel will ignore if not)
                try {
                    $table->dropForeign(['contract_id']);
                } catch (\Throwable $e) { /* noop */ }

                try {
                    $table->dropForeign(['product_id']);
                } catch (\Throwable $e) { /* noop */ }
            });

            Schema::dropIfExists('contract_product');
        }
    }
};