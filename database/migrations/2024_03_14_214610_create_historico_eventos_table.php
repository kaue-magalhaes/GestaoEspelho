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
        Schema::create('historico_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('tipo');
            $table->date('periodo_inicio');
            $table->date('periodo_fim');
            $table->foreignId('historico_promotor_titular_id')->references('id')->on('historico_promotores');
            $table->foreignId('historico_promotor_designado_id')->references('id')->on('historico_promotores');
            $table->foreignId('historico_id')->constrained('historicos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_eventos');
    }
};
