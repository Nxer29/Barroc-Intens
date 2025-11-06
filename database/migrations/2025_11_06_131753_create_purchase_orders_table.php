    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('purchase_orders', function (Blueprint $table) {
$table->id();
$table->foreignId('product_id')->constrained('products');
$table->integer('quantity');
$table->string('status')->nullable();
$table->timestamp('created_at')->useCurrent();
$table->foreignId('approved_by')->nullable()->constrained('users');
$table->foreignId('requested_by')->nullable()->constrained('users');
$table->decimal('total_cost', 14, 2)->nullable();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };