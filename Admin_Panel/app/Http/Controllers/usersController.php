<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Preset;
use App\Models\User;
use Illuminate\Http\Request;

class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Customer::with('presets')->get(['id','name', 'email', 'preset_id', 'phone']);
        // $presets = Preset::all(['id', 'name']);
        return view('users.index', compact('users', 'presets'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->phone = $request->input('phone');
        $user->preset_id = $request->input('preset_id');
        $user->save();

        return redirect()->route('users.index')->with('success', 'User  created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Customer::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Customer::find($id);
        return view('users.edit', compact('user'));
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
        $user = Customer::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->preset_id = $request->input('preset_id');
        
        $user->save();

        return redirect()->route('users.index')->with('success', 'User  updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Customer::find($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User  deleted successfully');
    }
}
