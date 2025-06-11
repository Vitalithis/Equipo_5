<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use Stancl\Tenancy\Tenancy;

class InitializeTenancyByDomain
{
    public function handle(Request $request, Closure $next)
    {
        /** @var Tenancy $tenancy */
        $tenancy = app(Tenancy::class);

        $resolver = new DomainTenantResolver();

        $tenant = $resolver->resolve($request);

        if (!$tenant) {
            abort(404, 'Tenant no encontrado para este subdominio');
        }

        $tenancy->initialize($tenant);

        return $next($request);
    }
}
