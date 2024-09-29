<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Authorize
        Gate::authorize('has-permission',['show-admins']);
        // Gate::authorize('show-admins');
        // get data
        $admins = User::all();
        // pass data to view
        return view('Admin.admins.admins', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Authorize
        Gate::authorize('has-permission',['create-admins']);
        $permissions = Permission::all();
        return view('Admin.admins.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        // Authorize
        Gate::authorize('has-permission',['create-admins']);
        //validation
        // dd($request->all());
        // filter request
        $admin_data = $request->except('_token','permissions');
        // dd($admin_data);
        // hash password
        $admin_data['password'] = Hash::make($admin_data['password']);
        // 'password' => Hash::make($data['password']),
        // Add to database
        $insert_admin = User::create($admin_data);
        // Add permissions to admin
        $permissions = $insert_admin->permissions()->attach($request->input('permissions'));
        // redirect
        return redirect()->route('admins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Authorize
        Gate::authorize('has-permission',['manage-admins']);
        $admin = User::find($id);
        $permissions = Permission::all();
        return view('Admin.admins.edit', compact('admin', 'permissions'));
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
        Gate::authorize('has-permission',['manage-admins']);
        $admin = User::find($id);
        $update = $admin->update($request->except('_token','_method'));
        // update permissions
        $admin->permissions()->sync($request->input('permissions'));
        return redirect()->route('admins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('has-permission',['manage-admins']);
        $admin = User::find($id);
        $admin->delete();
        return redirect()->route('admins.index');
    }
}
