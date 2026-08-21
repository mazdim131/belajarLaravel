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
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // big integer
            $table->string('cover');
            $table->string('title');
            $table->integer('price');
            $table->text('description');
            $table->string('languange');
            $table->string('publisher');
            $table->string('writer');
            $table->date('release_data');
            $table->integer('page_of_book');

            // untuk fk: foreignkey, sumber table: constrained, jenis penghapusan: onDelete
            $table->foreignid('book_category_id')->constrained('book_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
