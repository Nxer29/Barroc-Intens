    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('feedback', function (Blueprint $table) {
$table->id();
$table->foreignId('customer_id')->nullable()->constrained('customers');
$table->foreignId('user_id')->nullable()->constrained('users');
$table->foreignId('staff_id')->nullable()->constrained('users');
$table->text('message')->nullable();
$table->timestamp('created_at')->useCurrent();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };