<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class ViveroTenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = 'vivero';
        $domain = 'vivero.plantaseditha.me';

        if (!Tenant::find($tenantId)) {
            $tenant = Tenant::create([
                'id' => $tenantId,
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
