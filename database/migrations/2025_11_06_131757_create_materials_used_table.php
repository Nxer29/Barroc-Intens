    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('materials_used', function (Blueprint $table) {
$table->id();
$table->foreignId('work_order_id')->constrained('work_orders')->cascadeOnDelete();
$table->foreignId('product_id')->nullable()->constrained('products');
$table->integer('quantity');
$table->decimal('unit_price', 12, 2)->nullable();
$table->timestamp('created_at')->useCurrent();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };