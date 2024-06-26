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
        Schema::create('historico_espelhos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->dateTime('periodo_inicio');
            $table->dateTime('periodo_fim');
            $table->unsignedBigInteger('usuario_id');
            $table->foreignId('historico_id')->constrained('historicos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_espelhos');
    }
};
