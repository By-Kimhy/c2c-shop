<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add 'paid' to the enum list. Adjust order if you prefer.
        DB::statement("ALTER TABLE `payments` MODIFY `status` ENUM('pending','confirmed','failed','paid') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // revert to original enum values (drop 'paid')
        DB::statement("ALTER TABLE `payments` MODIFY `status` ENUM('pending','confirmed','failed') NOT NULL DEFAULT 'pending'");
    }
};
