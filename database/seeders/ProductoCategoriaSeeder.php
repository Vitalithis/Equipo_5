<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoCategoriaSeeder extends Seeder
{
    public function run()
    {
        // Desactivar revisión de claves foráneas para mejor performance
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpiar la tabla pivote primero (opcional)
        DB::table('producto_categoria')->truncate();

        // Contadores para el reporte
        $success = 0;
        $failed = 0;

        // Obtener todos los productos con categoría no nula
        $productos = Producto::whereNotNull('categoria')->get();

        foreach ($productos as $producto) {
            $categoriaId = $producto->getAttributes()['categoria'];

            // Verificar si la categoría existe
            $categoriaExistente = Categoria::find($categoriaId);

            if ($categoriaExistente) {
                // Insertar directamente en la tabla pivote (más eficiente para grandes volúmenes)
                DB::table('producto_categoria')->insertOrIgnore([
                    'producto_id' => $producto->id,
                    'categoria_id' => $categoriaId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $success++;
            } else {
                $this->command->error("⚠️ Producto ID {$producto->id} referencia categoría ID {$categoriaId} que no existe");
                $failed++;
            }
        }

        // Reactivar revisión de claves
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Reporte final
        $this->command->info("✔ {$success} relaciones creadas exitosamente");
        $this->command->warn("✖ {$failed} relaciones fallidas");
    }
}
