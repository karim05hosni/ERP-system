<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB as FacadesDB;

class RegisterationController extends Controller
{
    //
    // TenancyLayer/RegistrationController.php
    public function registerTenant(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email|unique:tenants',
            'password' => 'required',
            'domain' => 'required|unique:tenants',
            'name' => 'required',
        ]);

        // Create tenant record in central database
        $tenant = Tenant::create([
            'domain' => $validated['domain'],
            'name' => $validated['name'],
            'database' => $validated['domain'] . '_db', // e.g., "acme_db"
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Create the tenant's database
        FacadesDB::statement("CREATE DATABASE {$tenant->database}");
        // Set the tenant's database name
        config(['database.connections.tenant.database' => $tenant->database]);
        // Purge and reconnect to the tenant's database
        FacadesDB::purge('tenant');
        FacadesDB::reconnect('tenant');
        // Set the default connection to 'tenant'
        FacadesDB::setDefaultConnection('tenant');
        require __DIR__ . "/../../../../scripts/db.php";
        execute(__DIR__ . "/../../SQL_scripts/schema.sql", $tenant->database);
        // insert initial records in Admins and users table
        FacadesDB::table('users')->insert([
            'name' => $tenant->name,
            'email' => $tenant->email,
            'password' => sha1($validated['password']),
            'email_verified_at'=>date('Y-m-d G:i:s'),
            'status'=>'1'
        ]);
        FacadesDB::table('admins')->insert([
            'name' => $tenant->name,
            'email' => $tenant->email,
            'password' => $tenant->password,
            'role'=> 'Super Admin'
        ]);
        FacadesDB::statement("
            INSERT INTO `permissions` (`id`, `name`) VALUES
            (1, 'delete-products'),
            (2, 'show-products'),
            (3, 'edit-products'),
            (4, 'create-products'),
            (5, 'manage-admins'),
            (6, 'show-admins'),
            (7, 'create-admins');
        ");
        FacadesDB::statement("
            INSERT INTO `admin_permission` (`admin_id`, `permission_id`) VALUES
            (1, 1),
            (1, 2),
            (1, 3),
            (1, 4),
            (1, 5),
            (1, 6),
            (1, 7);
        ");

        // Step 1: Add to hosts file
        $hostsResult = $this->addSubdomainToHosts($tenant->domain);
        // Step 2: Add virtual host to Apache config
        $vhostResult = $this->addApacheVirtualHost($tenant->domain);
        // Step 3: Restart Apache to apply changes
        exec('D:\Laravel_Projects\xampp\apache\bin\httpd.exe -k restart');
        return response()->json(['message' => 'Tenant created succesfuly !']);
    }
    private function addSubdomainToHosts($tenantName)
    {
        $hostsFile = 'C:\Windows\System32\drivers\etc\hosts';  // Windows hosts file
        $newEntry = "127.0.0.1    {$tenantName}.root\n127.0.0.1    {$tenantName}.erp\n";
        if (strpos(file_get_contents($hostsFile), $tenantName) === false) {
            file_put_contents($hostsFile, $newEntry, FILE_APPEND);
            return "Subdomain {$tenantName} added successfully!";
        }
        return "Subdomain already exists!";
    }
    private function addApacheVirtualHost($tenantSubdomain)
    {
        $vhostFile = 'D:\Laravel_Projects\xampp\apache\conf\extra\httpd-vhosts.conf';  // Windows path
        $vhostEntry = "
    <VirtualHost *:80>
        ServerName {$tenantSubdomain}.localhost
        DocumentRoot \"D:\Laravel_Projects/xampp/htdocs/root\"
        <Directory \"D:\Laravel_Projects/xampp/htdocs/root\">
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
        ";
        if (strpos(file_get_contents($vhostFile), $tenantSubdomain) === false) {
            file_put_contents($vhostFile, $vhostEntry, FILE_APPEND);
            return "Apache Virtual Host for {$tenantSubdomain} added successfully!";
        }
        return "Virtual Host already exists!";
    }
}
