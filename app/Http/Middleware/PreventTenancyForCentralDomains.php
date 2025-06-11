<?php

namespace App\Http\Middleware;

use Closure;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

class PreventTenancyForCentralDomains extends InitializeTenancyByDomain
{
    public function handle($request, Closure $next)
    {
        $centralDomains = config('tenancy.central_domains', []);

        if (in_array($request->getHost(), $centralDomains)) {
            return $next($request); // No activar tenancy
        }

        return parent::handle($request, $next);
    }
}

