    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('invoice_lines', function (Blueprint $table) {
$table->id();
$table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
$table->foreignId('product_id')->nullable()->constrained('products');
$table->text('description')->nullable();
$table->integer('quantity');
$table->decimal('unit_price', 12, 2);
$table->decimal('line_total', 12, 2);
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };