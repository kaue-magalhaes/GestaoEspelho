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
        Schema::create('historico_urgencia_atendimentos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('periodo_inicio');
            $table->dateTime('periodo_fim');
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
        Schema::dropIfExists('historico_urgencia_atendimentos');
    }
};
