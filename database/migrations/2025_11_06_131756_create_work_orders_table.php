    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('work_orders', function (Blueprint $table) {
$table->id();
$table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
$table->foreignId('performed_by')->nullable()->constrained('users');
$table->text('notes')->nullable();
$table->timestamp('created_at')->useCurrent();
$table->boolean('sent_to_manager')->default(false);
$table->timestamp('manager_received_at')->nullable();
$table->string('external_reference')->nullable();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };