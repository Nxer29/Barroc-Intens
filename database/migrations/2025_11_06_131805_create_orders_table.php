    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('orders', function (Blueprint $table) {
$table->id();
$table->string('order_number')->unique();
$table->foreignId('customer_id')->constrained('customers');
$table->foreignId('product_id')->constrained('products');
$table->integer('quantity');
$table->date('order_date')->nullable();
$table->string('status')->nullable();
$table->timestamps();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };