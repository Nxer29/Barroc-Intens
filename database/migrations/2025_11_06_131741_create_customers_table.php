    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {

Schema::create('customers', function (Blueprint $table) {
$table->id();
$table->string('company_name');
$table->string('contact_name')->nullable();
$table->string('contact_email')->nullable();
$table->string('contact_phone')->nullable();
$table->string('status')->nullable();
$table->string('bkr_status')->nullable();
$table->foreignId('invoice_address_id')->nullable()->constrained('addresses');
$table->foreignId('delivery_address_id')->nullable()->constrained('addresses');
$table->foreignId('created_by')->nullable()->constrained('users');
$table->timestamps();
});
        }

        public function down(): void
        {
            // handled per table below if needed
        }
    };