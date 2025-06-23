<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plant_treatments', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo');
            $table->text('composicion')->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->string('unidad_medida')->nullable();
            $table->string('presentacion')->nullable();
            $table->text('aplicacion')->nullable();
            $table->string('frecuencia_aplicacion')->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->date('fecha_vencimiento')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_treatments');
    }
};
