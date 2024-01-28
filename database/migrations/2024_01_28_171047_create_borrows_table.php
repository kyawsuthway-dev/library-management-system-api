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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'fk_borrows_user_id'
            )->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('book_id')->constrained(
                table: 'books', indexName: 'fk_borrows_book_id'
            )->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
