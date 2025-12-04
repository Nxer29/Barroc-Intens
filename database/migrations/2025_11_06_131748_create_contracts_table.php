    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('contracts', function (Blueprint $table) {
$table->id();
$table->string('name')->nullable();
$table->string('contract_number')->unique();
$table->foreignId('quote_id')->nullable()->constrained('quotes');
$table->foreignId('customer_id')->constrained('customers');
$table->timestamp('signed_at')->nullable();
$table->date('start_date')->nullable();
$table->date('end_date')->nullable();
$table->string('billing_cycle')->nullable();
$table->string('pdf_url')->nullable();
$table->string('status')->nullable();
$table->boolean('bkr_checked')->default(false);
$table->boolean('bkr_passed')->default(false);
$table->foreignId('created_by')->nullable()->constrained('users');
$table->timestamps();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };