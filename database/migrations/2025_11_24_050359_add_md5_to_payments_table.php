<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('payments', 'md5')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('md5', 64)->nullable()->after('provider_ref')->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('payments', 'md5')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('md5');
            });
        }
    }
};
