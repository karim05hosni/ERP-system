<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Http\Controllers\Controller;
use App\Http\traits\Api_Response_Trait;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
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
        $inventories = Inventory::all();
        return $this->Api_Response(message: 'inventories Retrieved Successfuly !', data: $inventories);
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
        $data = json_decode($request->getContent(), true);
        $inventory = Inventory::create($data);
        return $this->Api_Response(message: 'inventory Created Successfuly !', data: $inventory);
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
        $inventory = Inventory::find($data['id']);
        return $this->Api_Response(message: 'inventory Retrieved Successfuly !', data: $inventory);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = json_decode($request->getContent(), true);
        Inventory::find($data['id'])->delete();
        return $this->Api_Response(message:'Inventory deleted successfuly !');
    }
}
