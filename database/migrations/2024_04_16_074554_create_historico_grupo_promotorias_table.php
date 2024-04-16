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
        Schema::create('historico_grupo_promotorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('historico_municipio_id')->references('id')->on('historico_municipios');
            $table->foreignId('historico_id')->constrained('historicos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_grupo_promotorias');
    }
};
