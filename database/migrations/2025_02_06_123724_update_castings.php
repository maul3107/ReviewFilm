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
        Schema::table('castings', function (Blueprint $table) {
            $table->foreign('film_id')->references('id')->on('films')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('castings', function (Blueprint $table) {
            $table->dropForeign(['film_id']);
        });
    }
};
