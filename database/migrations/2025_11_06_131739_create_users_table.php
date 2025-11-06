    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('users', function (Blueprint $table) {
$table->id();
$table->string('full_name')->nullable();
$table->string('email')->unique();
$table->string('password_hash')->nullable();
$table->foreignId('role_id')->nullable()->constrained('roles');
$table->string('phone')->nullable();
$table->string('department')->nullable();
$table->boolean('is_employee')->default(true);
$table->timestamps();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };