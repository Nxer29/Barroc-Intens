<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('contracts') && ! Schema::hasColumn('contracts', 'recurring_amount')) {
            Schema::table('contracts', function (Blueprint $table) {
                $table->decimal('recurring_amount', 12, 2)->nullable()->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('contracts') && Schema::hasColumn('contracts', 'recurring_amount')) {
            Schema::table('contracts', function (Blueprint $table) {
                $table->dropColumn('recurring_amount');
            });
        }
    }
};