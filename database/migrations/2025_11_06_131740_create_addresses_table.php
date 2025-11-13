    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('addresses', function (Blueprint $table) {
$table->id();
$table->string('street')->nullable();
$table->string('city')->nullable();
$table->string('postal_code')->nullable();
$table->string('country')->nullable();
$table->text('extra')->nullable();
$table->timestamps();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };