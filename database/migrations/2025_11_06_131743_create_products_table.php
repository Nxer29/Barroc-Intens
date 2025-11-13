    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('products', function (Blueprint $table) {
$table->id();
$table->string('sku')->nullable()->unique();
$table->string('name');
$table->string('brand')->nullable();
$table->text('description')->nullable();
$table->foreignId('category_id')->nullable()->constrained('product_categories');
$table->decimal('unit_price', 12, 2)->nullable();
$table->decimal('price', 12, 2)->nullable();
$table->boolean('is_visible_to_customers')->default(true);
$table->integer('stock')->default(0);
$table->timestamps();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };