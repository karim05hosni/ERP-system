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
        $data = json_decode($request->getContent(), true);
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
    public function destroy($id)
    {
        //
    }
}
