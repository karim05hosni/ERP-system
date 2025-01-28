<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function login(Request $request) {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find the tenant by email
        $tenant = Tenant::where('email', $request->email)->first();

        // Check if the tenant exists and the password is correct
        if (!$tenant || !Hash::check($request->password, $tenant->password)) {
            return response()->json(['message' => 'Wrong email or password'], 401);
        }

        // Log the tenant into the session (optional, only if you need session-based auth)
        Auth::login($tenant);

        // Generate a token for the tenant
        $token = $tenant->createToken('AuthToken', ['tenant_id' => $tenant->id])->plainTextToken;
        config(['database.connections.tenant.database' => $tenant->database]);
        // Purge and reconnect to the tenant's database
        FacadesDB::purge('tenant');
        FacadesDB::reconnect('tenant');
        // Set the default connection to 'tenant'
        FacadesDB::setDefaultConnection('tenant');
        // Return the token and user details
        return response()->json([
            'message' => 'Logged in successfully!',
            'token' => $token,
            'user' => $tenant, // Use $tenant instead of Auth::user() for token-based auth
        ]);
    }
}
