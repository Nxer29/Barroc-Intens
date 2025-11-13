    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('internal_messages', function (Blueprint $table) {
$table->id();
$table->foreignId('sender_id')->constrained('users');
$table->foreignId('receiver_id')->nullable()->constrained('users');
$table->foreignId('customer_id')->nullable()->constrained('customers');
$table->text('content')->nullable();
$table->timestamp('created_at')->useCurrent();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };