<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGastosTransporteTable extends Migration
{
    public function up(): void
    {
        Schema::create('gastos_transporte', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->enum('tipo_gasto', ['movilizacion', 'reparto', 'retiro', 'flete']);
            $table->string('transportista_nombre');
            $table->string('transportista_contacto');
            $table->string('vehiculo_descripcion')->nullable();
            $table->decimal('monto', 10, 2);
            $table->text('detalle')->nullable();
            $table->string('comprobante_path')->nullable();
            $table->boolean('pagado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos_transporte');
    }
}
