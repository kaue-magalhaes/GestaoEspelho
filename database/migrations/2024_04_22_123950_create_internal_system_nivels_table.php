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
        Schema::create('internal_system_nivels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->references('id')->on('internal_system_users')->onDelete('cascade');
            $table->string('sistema');
            $table->integer('nivel')->unsigned()->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_system_nivels');
    }
};
