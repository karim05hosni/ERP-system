<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\JWT;

class RoutingController extends Controller
{
    //
    private $subdomain;
    public function __construct(){
        $host = $_SERVER['HTTP_HOST'];
        $this->subdomain = explode('.', $host)[0];
        if ($this->subdomain !== 'EnterpriseSoftware') {
            define('TENANT_ID', $this->subdomain);
            // Load tenant-specific config
            $configPath = __DIR__ . "/config/tenants/{$this->subdomain}.php";
            if (file_exists($configPath)) {
                include $configPath;
            }
        }
    }
    public function forwardToEcommerce(Request $request)
    {
        return $this->forwardRequest($request, 'http://'.$this->subdomain.'.root/ecommerce/shop.php');
    }

    // Forward requests to the ERP app
    public function forwardToErp(Request $request)
    {
        return $this->forwardRequest($request, 'http://'.$this->subdomain.'.erp/dashboard');
    }
    private function forwardRequest(Request $request, $targetUrl)
    {
        // if (isset($_COOKIE['Authorization'])){
        //     setcookie('Authorization', $request->header('Authorization'), -1, '/');
        // }
        // if (isset($_COOKIE['tenant_db'])){
        //     dd($request->user()->database);
        //     setcookie('tenant_db', $request->header('Authorization'), -1, '/');
        // }
        // if (isset($_COOKIE['tenant_id'])){
        //     setcookie('tenant_id', $request->header('Authorization'), -1, '/');
        // }
        setcookie('Authorization', $request->header('Authorization'), time() + (86400 * 12), '/');
        setcookie('tenant_db', $request->user()->database, time() + (86400 * 12), '/');
        setcookie('tenant_id', $request->user()->id, time() + (86400 * 12), '/');
            // dd('sss');
        return $targetUrl;
    }
}
