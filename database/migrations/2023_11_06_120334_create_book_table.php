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
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('author');
            $table->string('description')->nullable(true);
            $table->string('image')->nullable(true);
            $table->string('publisher');
            $table->tinyInteger('status');
            $table->string('isbn')->nullable(true);
            $table->integer('page_num')->nullable(true);
            $table->string('edition')->nullable(true);
            $table->string('section')->nullable(true);
            $table->string('bookshelf')->nullable(true);
            $table->integer('publish');
            $table->integer('qtd');
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
