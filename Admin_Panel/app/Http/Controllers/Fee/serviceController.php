<?php

namespace App\Http\Controllers\Fee;

use App\Http\Controllers\Controller;
use App\Models\FeePercentage;
use App\Models\Preset;
use App\Models\Service;
use App\Models\Threshold;
use Illuminate\Http\Request;

class serviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        $presets = Preset::all();
        $services = Service::all();
        $thresholds = Threshold::all();
        $feePercentage = FeePercentage::all();
        return view('fee.services.index', compact('services', 'presets', 'thresholds', 'feePercentage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $presets = Preset::all();
        $threholds = Threshold::all();
        return view('fee.services.create', compact('presets', 'threholds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $service = Service::create([
            'name' => $request->input('service_name'),
        ]);
        $preset = Preset::find($request->input('preset_id'));
        $service->presets()->attach($preset);
        foreach ($request->input('thresholds') as $threshold) {
            $created_threhold = Threshold::create([
                'min_amount' => $threshold['min_value'],
                'max_amount' => $threshold['max_value'],
                'service_id' => $service->id,
            ]);
            FeePercentage::create([
                'value'=>$threshold['fee_percentage'],
                'preset_id'=> $preset->id,
                'service_id'=> $service->id,
                'thresholds_id'=> $created_threhold->id
            ]);
        }
        return redirect()->route('fee.services.index')->with('success', 'Service created successfully');
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
        $feeService= Service::find($id);
        return view('fee.services.edit', compact('feeService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
        Service::find($id)->delete();
        return redirect()->back();
    }
}
