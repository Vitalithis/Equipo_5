<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class SoporteTenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = 'soporte';
        $domain = 'soporte.plantaseditha.me';

        $tenant = Tenant::find($tenantId);

        if (!$tenant) {
            $tenant = new Tenant();
            $tenant->id = $tenantId;
            $tenant->data = [
                'nombre' => 'Soporte',
                'activo' => true,
            ];
            $tenant->save();

            $this->command->info("✅ Tenant '{$tenantId}' creado con dominio '{$domain}'");
        } else {
            $this->command->warn("⚠️ Tenant '{$tenantId}' ya existe. Seeder omitido.");

            $needsUpdate = empty($tenant->data['nombre']) || !array_key_exists('activo', $tenant->data);
            if ($needsUpdate) {
                $tenant->data = [
                    'nombre' => 'Soporte',
                    'activo' => true,
                ];
                $tenant->save();
                $this->command->info("ℹ️ Datos del tenant '{$tenantId}' actualizados.");
            }
        }

        if (!$tenant->domains()->where('domain', $domain)->exists()) {
            $tenant->domains()->create([
                'domain' => $domain,
            ]);
        }
    }
}
