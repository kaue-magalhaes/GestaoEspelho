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
        Schema::create('promotorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('is_especializada')->default(true);
            $table->foreignId('espelho_id')->references('id')->on('espelhos');
            $table->foreignId('promotor_titular_id')->references('id')->on('promotores');
            $table->foreignId('grupo_promotoria_id')->references('id')->on('grupo_promotorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotorias');
    }
};
