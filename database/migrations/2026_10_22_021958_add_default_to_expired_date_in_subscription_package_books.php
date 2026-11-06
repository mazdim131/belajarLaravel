<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make expired_date nullable since we're not collecting it in this UI
        DB::statement('ALTER TABLE subscription_package_books MODIFY COLUMN expired_date DATE NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: MySQL doesn't easily support re-adding NOT NULL after removing it
        // This is a known limitation when working without doctrine/dbal
    }
};
