    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('invoices', function (Blueprint $table) {
$table->id();
$table->string('invoice_number')->unique();
$table->foreignId('contract_id')->nullable()->constrained('contracts');
$table->foreignId('customer_id')->constrained('customers');
$table->date('issue_date')->nullable();
$table->date('due_date')->nullable();
$table->decimal('total_amount', 12, 2)->nullable();
$table->string('status')->nullable();
$table->timestamp('sent_at')->nullable();
$table->timestamp('paid_at')->nullable();
$table->timestamp('created_at')->useCurrent();
$table->foreignId('approved_by')->nullable()->constrained('users');
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };