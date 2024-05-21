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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('tipo');
            $table->dateTime('periodo_inicio');
            $table->dateTime('periodo_fim');
            $table->unsignedBigInteger('promotor_titular_id');
            $table->unsignedBigInteger('promotor_designado_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
