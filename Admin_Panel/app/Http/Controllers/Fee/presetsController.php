<?php

namespace App\Http\Controllers\Fee;

use App\Http\Controllers\Controller;

use App\Models\Preset;
use Illuminate\Http\Request;

class presetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $feePresets= Preset::all();
        return view('fee.presets.index', compact('feePresets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get services
        return view('fee.presets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Preset::create([
            'name' => $request->input('preset_name'),
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $preset = Preset::find($id);
        return view('fee.presets.edit', compact('preset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //
        Preset::find($id)->update([
            'name' => $request->input('preset_name'),
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
        Preset::find($id)->delete();
    }
}
