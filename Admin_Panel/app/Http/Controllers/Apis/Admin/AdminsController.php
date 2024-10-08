<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Http\Controllers\Controller;
use App\Http\traits\Admin_Api_Response_Trait;
use App\Http\traits\Api_Response_Trait;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    use Admin_Api_Response_Trait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Authorize
        // Gate::authorize('has-permission',['show-admins']);
        // Gate::authorize('show-admins');
        // get data
        $admins = User::all();
        // pass data to view
        return $this->Api_Response(message: 'Admins Retrieved Successfuly !', data: compact('admins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Authorize
        Gate::authorize('has-permission',['create-admins']);
        //validation
        // filter request
        $admin_data = $request->except('_token','permissions');
        // dd($admin_data);
        // hash password
        $admin_data['password'] = Hash::make($admin_data['password']);
        // 'password' => Hash::make($data['password']),
         // Add to database
        $insert_admin = User::create($admin_data);
        if (!$insert_admin){
            return $this->
            Api_Response(400, message: 'Error in insert admin', errors: $insert_admin);
        }
        // Add permissions to admin
        $permissions = $insert_admin->permissions()->attach($request->input('permissions'));
        // response
        return $this->Api_Response(message: 'Admin Added Successfuly !', data: compact($insert_admin));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
