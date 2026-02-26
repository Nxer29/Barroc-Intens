<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('bkr_status')->default('not_started')->after('bkr_passed');
            $table->date('bkr_status_date')->nullable()->after('bkr_status');
            $table->text('bkr_note')->nullable()->after('bkr_status_date');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['bkr_status', 'bkr_status_date', 'bkr_note']);
        });
    }
};
