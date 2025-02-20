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
        Schema::create('films', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 80);
            $table->string('poster', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->integer('release_year');
            $table->integer('duration');
            $table->integer('rating');
            $table->string('creator', 255);
            $table->string('trailer', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
