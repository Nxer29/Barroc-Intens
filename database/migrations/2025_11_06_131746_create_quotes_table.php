    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('quotes', function (Blueprint $table) {
$table->id();
$table->string('quote_number')->unique();
$table->foreignId('customer_id')->constrained('customers');
$table->foreignId('created_by')->constrained('users');
$table->timestamp('created_at')->useCurrent();
$table->date('valid_until')->nullable();
$table->string('status')->nullable();
$table->decimal('total_amount', 12, 2)->nullable();
$table->text('preferences')->nullable();
$table->integer('machines_count')->nullable();
$table->string('pdf_url')->nullable();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };