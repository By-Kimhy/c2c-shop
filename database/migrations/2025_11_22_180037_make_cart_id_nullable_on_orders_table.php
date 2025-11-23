<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'cart_id')) {
                // change to nullable unsignedBigInteger — adjust if your column type differs
                $table->unsignedBigInteger('cart_id')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'cart_id')) {
                $table->unsignedBigInteger('cart_id')->nullable(false)->change();
            }
        });
    }
};
