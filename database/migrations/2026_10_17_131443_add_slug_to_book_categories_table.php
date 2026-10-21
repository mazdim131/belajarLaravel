<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // kolom slug sudah ikut dibuat di migration create_book_categories_table
        // jadi migration ini dilewati kalau kolomnya sudah ada
        // tanpa pengecekan ini, migrate:fresh akan gagal dengan "Duplicate column name 'slug'"
        if (Schema::hasColumn('book_categories', 'slug')) {
            return;
        }

        Schema::table('book_categories', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
