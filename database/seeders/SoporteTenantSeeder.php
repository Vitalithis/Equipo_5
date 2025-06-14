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

        if (!Tenant::find($tenantId)) {
            $tenant = Tenant::create([
                'id' => $tenantId,
                'nombre' => 'Soporte',
                'activo' => true,
            ]);

            $tenant->domains()->create([
                'domain' => $domain,
            ]);

            $this->command->info("✅ Tenant '{$tenantId}' creado con dominio '{$domain}'");
        } else {
            $this->command->warn("⚠️ Tenant '{$tenantId}' ya existe. Seeder omitido.");
        }
    }
}
