<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Producto;
use Illuminate\Support\Facades\Artisan;
use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;

class MigrateToTenancy extends Command
{
    protected $signature = 'tenancy:migrate-from-central';

    protected $description = 'Crear tenants y migrar datos desde la base central usando arquitectura tenancy';

    public function handle()
    {
        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {
            $tenantId = $cliente->slug; // usado como ID y nombre de la base de datos

            $this->info("▶ Creando tenant '$tenantId'...");

            // Crear tenant si no existe
            if (Tenant::find($tenantId)) {
                $this->warn("⚠️  El tenant '$tenantId' ya existe. Saltando...");
                continue;
            }

            $tenant = Tenant::create([
                'id' => $tenantId,
                'data' => [
                    'nombre' => $cliente->nombre,
                    'activo' => $cliente->activo,
                ],
            ]);

            // Crear dominio asociado
            Domain::create([
                'domain' => "$tenantId.plantaseditha.me", // Reemplaza por tu dominio real
                'tenant_id' => $tenantId,
            ]);

            // Crear base de datos física
            $tenant->createDatabase();

            $this->info("✅ Base de datos '$tenantId' creada.");

            // Ejecutar migraciones del tenant
            $tenant->run(function () {
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/tenant',
                    '--force' => true,
                ]);
            });

            // Migrar datos (ahora sin cliente_id)
            $tenant->run(function () use ($cliente) {
                // Migrar usuarios (sin filtro cliente_id)
                $usuarios = User::all();
                foreach ($usuarios as $u) {
                    User::create($u->only(['name', 'email', 'password']));
                }

                // Migrar productos (sin filtro cliente_id)
                $productos = Producto::all();
                foreach ($productos as $p) {
                    Producto::create($p->only(['nombre', 'descripcion', 'precio', 'stock']));
                }

                // Agrega aquí otros modelos si necesitas migrar datos globales o iniciales.
            });

            $this->info("✅ Datos migrados para '$tenantId'.\n");
        }

        $this->info('🎉 Migración completa para todos los tenants.');
    }
}
