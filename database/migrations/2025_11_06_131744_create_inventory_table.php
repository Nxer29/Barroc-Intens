    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('inventory', function (Blueprint $table) {
$table->id();
$table->foreignId('product_id')->constrained('products');
$table->integer('quantity')->default(0);
$table->integer('min_threshold')->default(0);
$table->string('location')->nullable();
$table->timestamp('updated_at')->nullable();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };