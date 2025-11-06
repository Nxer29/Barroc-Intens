    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('stock_movements', function (Blueprint $table) {
$table->id();
$table->foreignId('product_id')->constrained('products');
$table->integer('change');
$table->string('reason')->nullable();
$table->string('reference_type')->nullable();
$table->unsignedBigInteger('reference_id')->nullable();
$table->foreignId('performed_by')->nullable()->constrained('users');
$table->timestamp('created_at')->useCurrent();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };