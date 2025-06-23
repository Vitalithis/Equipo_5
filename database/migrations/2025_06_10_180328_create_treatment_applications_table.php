<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('treatment_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_treatment_id')->constrained()->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->date('fecha_aplicacion');
            $table->string('dosis_aplicada')->nullable();
            $table->text('notas')->nullable();
            $table->date('proxima_aplicacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_applications');
    }
};
