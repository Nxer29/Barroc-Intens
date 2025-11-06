    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('payments', function (Blueprint $table) {
$table->id();
$table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
$table->timestamp('paid_at')->nullable();
$table->decimal('amount', 12, 2);
$table->string('method')->nullable();
$table->string('reference')->nullable();
$table->foreignId('created_by')->nullable()->constrained('users');
$table->timestamp('created_at')->useCurrent();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };