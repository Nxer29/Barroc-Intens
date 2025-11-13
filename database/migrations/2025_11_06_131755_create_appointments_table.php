    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('appointments', function (Blueprint $table) {
$table->id();
$table->foreignId('maintenance_request_id')->constrained('maintenance_requests')->cascadeOnDelete();
$table->timestamp('scheduled_start')->nullable();
$table->timestamp('scheduled_end')->nullable();
$table->foreignId('assignee_id')->nullable()->constrained('users');
$table->text('location')->nullable();
$table->string('status')->nullable();
$table->foreignId('created_by')->nullable()->constrained('users');
$table->timestamp('created_at')->useCurrent();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };