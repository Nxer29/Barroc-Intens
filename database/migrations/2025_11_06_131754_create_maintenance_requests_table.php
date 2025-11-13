    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('maintenance_requests', function (Blueprint $table) {
$table->id();
$table->string('request_number')->unique();
$table->foreignId('customer_id')->nullable()->constrained('customers');
$table->foreignId('product_id')->nullable()->constrained('products');
$table->foreignId('contract_id')->nullable()->constrained('contracts');
$table->foreignId('reported_by')->nullable()->constrained('users');
$table->foreignId('assigned_to')->nullable()->constrained('users');
$table->text('issue_description')->nullable();
$table->string('urgency')->nullable();
$table->string('priority')->nullable();
$table->string('status')->nullable();
$table->timestamp('scheduled_at')->nullable();
$table->text('feedback_text')->nullable();
$table->timestamps();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };