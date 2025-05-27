<?php

// database/migrations/xxxx_xx_xx_create_insumos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo_uso', ['venta', 'uso']);
            $table->integer('stock')->default(0);
            $table->integer('precio')->nullable(); // Solo si es para venta
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
