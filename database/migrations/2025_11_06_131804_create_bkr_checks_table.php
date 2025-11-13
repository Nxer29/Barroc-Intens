    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('bkr_checks', function (Blueprint $table) {
$table->id();
$table->foreignId('customer_id')->constrained('customers');
$table->foreignId('checked_by')->nullable()->constrained('users');
$table->string('status')->nullable();
$table->timestamp('checked_at')->nullable();
$table->text('notes')->nullable();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };