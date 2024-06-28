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
        Schema::create('internal_system_users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('login_intranet')->unique();
            $table->string('senha_intranet');
            $table->string('matricula')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_system_users');
    }
};
