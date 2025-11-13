    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('notifications', function (Blueprint $table) {
$table->id();
$table->foreignId('user_id')->constrained('users');
$table->string('type');
$table->json('payload');
$table->boolean('is_read')->default(false);
$table->timestamp('created_at')->useCurrent();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };