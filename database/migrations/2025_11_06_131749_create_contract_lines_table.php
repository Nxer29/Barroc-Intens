    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('contract_lines', function (Blueprint $table) {
$table->id();
$table->foreignId('contract_id')->constrained('contracts')->cascadeOnDelete();
$table->foreignId('product_id')->nullable()->constrained('products');
$table->integer('quantity')->default(1);
$table->integer('monthly_beans')->nullable();
$table->string('bean_type')->nullable();
$table->decimal('unit_price', 12, 2)->nullable();
$table->text('notes')->nullable();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };