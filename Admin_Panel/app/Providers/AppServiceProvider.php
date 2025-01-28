<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $host = $_SERVER['HTTP_HOST'];
        $subdomain = explode('.', $host)[0];
        // echo $subdomain;die;
        // dd($subdomain.'_db');
        if ($subdomain != 'enterprisesoftware') {
            config(['database.connections.tenant.database' => $subdomain.'_db']);
            // Purge and reconnect to the tenant's database
            DB::purge('tenant');
            DB::reconnect('tenant');
            // Set the default connection to 'tenant'
            DB::setDefaultConnection('tenant');
        }
        // JsonResource::withoutWrapping();
    }
}
