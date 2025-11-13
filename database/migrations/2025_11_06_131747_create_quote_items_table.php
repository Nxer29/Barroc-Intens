    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('quote_items', function (Blueprint $table) {
$table->id();
$table->foreignId('quote_id')->constrained('quotes')->cascadeOnDelete();
$table->foreignId('product_id')->nullable()->constrained('products');
$table->integer('quantity');
$table->decimal('unit_price', 12, 2);
$table->decimal('line_total', 12, 2);
$table->text('description')->nullable();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };