<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->string('publisher')->nullable();
            $table->date('publication_date')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('isbn')->unique();
            $table->integer('page_count')->unsigned()->nullable();
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
