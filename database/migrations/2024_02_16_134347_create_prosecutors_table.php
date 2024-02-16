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
        Schema::create('prosecutors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('county');
            $table->boolean('is_specialized')->default(false);
            $table->foreignId('justice_promoter_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosecutors');
    }
};
