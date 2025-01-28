<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next) {
        // Get tenant_id from JWT token
        // $tenantId = Auth::user()->token()->claims()->get('tenant_id');
         // Get the authenticated user (tenant)
        $tenant = $request->user();
        // session auth
        $tenant = session('tenant');
        // dd(Auth::user());
        // Get the tenant_id from the authenticated user
        $tenant = Auth::user();
        // Fetch tenant details from central database
        $tenant = Tenant::findOrFail($tenant->id);
        // Configure the tenant's database connection
        $host = $_SERVER['HTTP_HOST'];
        $subdomain = explode('.', $host)[0];
        if ($subdomain !== 'enterprisesoftware') {
            // Configure the tenant's database dynamically
            Config::set('database.connections.tenant.database', $tenant->database);
            DB::purge('tenant'); // Clear existing connection
            DB::reconnect('tenant'); // Reconnect with new database name
            // Set the default database connection to "tenant"
            Config::set('database.default', 'tenant');
        }
        // dd(config('database.connections.tenant'));
        return $next($request);
    }
}
