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
        Schema::create('historico_promotorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('is_especializada')->default(true);
            $table->foreignId('historico_espelho_id')->references('id')->on('historico_espelhos');
            $table->foreignId('historico_promotor_titular_id')->references('id')->on('historico_promotores');
            $table->foreignId('historico_grupo_promotoria_id')->references('id')->on('historico_grupo_promotorias');
            $table->foreignId('historico_id')->references('id')->on('historicos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_promotorias');
    }
};
