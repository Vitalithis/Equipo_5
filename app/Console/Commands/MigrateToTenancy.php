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

    protected $description = 'Crear tenants y migrar datos desde la base central usando cliente_id';

    public function handle()
    {
        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {
            $tenantId = $cliente->slug; // usado como ID y nombre de la base de datos

            $this->info("▶ Creando tenant '$tenantId'...");

            // Crear tenant
            if (Tenant::find($tenantId)) {
                $this->warn("⚠️  El tenant '$tenantId' ya existe. Saltando...");
                continue;
            }
            
            $tenant = Tenant::create([
                'id' => $tenantId,
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

            // Copiar datos desde la base central a este tenant
            $tenant->run(function () use ($cliente) {
                // Migrar usuarios
                $usuarios = User::where('cliente_id', $cliente->id)->get();
                foreach ($usuarios as $u) {
                    User::create($u->only(['name', 'email', 'password']));
                }

                // Migrar productos
                $productos = Producto::where('cliente_id', $cliente->id)->get();
                foreach ($productos as $p) {
                    Producto::create($p->only(['nombre', 'descripcion', 'precio', 'stock']));
                }

                // Agrega aquí otros modelos como pedidos, insumos, etc.
            });

            $this->info("✅ Datos migrados para '$tenantId'.\n");
        }

        $this->info('🎉 Migración completa para todos los tenants.');
    }
}
