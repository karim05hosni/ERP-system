<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Http\Controllers\Controller;
use App\Http\traits\Api_Response_Trait;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouserController extends Controller
{
    use Api_Response_Trait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $warehouses = Warehouse::all();
        return $this->Api_Response(message:'Warehouses Retrieved Successfuly !', data:$warehouses);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // decode JSON
        parse_str($request->getContent(), $outputArray);
        // Convert the associative array to JSON
        $jsonOutput = json_encode($outputArray);
        // Decode JSON data from the request
        $data = json_decode($jsonOutput, true);
        $warehouse = Warehouse::create($data);
        return $this->Api_Response(message:'Warehouse Created Successfuly !', data:$warehouse);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $warehouse = Warehouse::find($data['id']);
        return $this->Api_Response(message: 'Warehouse Retrieved Successfuly !', data: $warehouse);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    parse_str($request->getContent(), $outputArray);

    // Convert the associative array to JSON
    $jsonOutput = json_encode($outputArray);
    // Decode JSON data from the request
    $data = json_decode($jsonOutput, true);

    // dd($data);
    // Find the warehouse by ID
    $warehouse = Warehouse::find($id);
    // Check if warehouse exists
    if (!$warehouse) {
        return $this->Api_Response(message: 'Warehouse Not Found!', status: 404);
    }
    
    // Update the warehouse with the new data
    $warehouse->update($data);

    return $this->Api_Response(message: 'Warehouse Updated Successfully!', data: $warehouse);
}

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
    // Find the warehouse by ID
    $warehouse = Warehouse::find($id);

    // Check if warehouse exists
    if (!$warehouse) {
        return $this->Api_Response(message: 'Warehouse Not Found!', status: 404);
    }

    // Delete the warehouse
    $warehouse->delete();

    return $this->Api_Response(message: 'Warehouse Deleted Successfully!');
}
}
