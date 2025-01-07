<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Http\Controllers\Controller;
use App\Http\traits\Api_Response_Trait;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    use Api_Response_Trait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    //     $inventories = Inventory::all();
    //     return $this->Api_Response(message: 'inventories Retrieved Successfuly !', data: $inventories);
    // }
    public function index()
    {
        // Fetch inventory with relationships and calculations
        $inventories = Inventory::with(['product', 'warehouse'])
            ->get()
            ->map(function ($inventory) {
                // Calculate quantity_sold from the OrderProduct table
                $quantitySold = OrderProduct::where('product_id', $inventory->product_id)
                    ->where('warehouse_id', $inventory->warehouse_id)
                    ->sum('quantity');

                return [
                    'id' => $inventory->id,
                    'product_name' => $inventory->product->name_en, // Assuming the Product model has a 'name' field
                    'quantity_inhand' => $inventory->quantity,
                    'warehouse_location' => $inventory->warehouse->location,
                    'warehouse_district' => $inventory->warehouse->district,
                    'quantity_sold' => $quantitySold,
                ];
            });

        // Return the modified response
        return response()->json([
            'User_api' => [
                'status' => 200,
                'message' => 'Inventories Retrieved Successfully!',
                'data' => $inventories,
            ],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity_inhand' => 'required|integer',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        Inventory::create($validatedData);

        return response()->json([
            'message' => 'Inventory added successfully!',
            'data' => $validatedData,
        ], 201);
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity_inhand' => 'required|integer|min:0',
            'warehouse_location' => 'required|string|max:255',
            'warehouse_district' => 'required|string|max:255',
            'quantity_sold' => 'nullable|integer|min:0',
        ]);

        // Find the inventory record by ID
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return response()->json([
                'status' => 404,
                'message' => 'Inventory record not found!',
            ], 404);
        }

        // Find the associated warehouse
        $warehouse = Warehouse::where('location', $validatedData['warehouse_location'])
            ->where('district', $validatedData['warehouse_district'])
            ->first();

        if (!$warehouse) {
            return response()->json([
                'status' => 404,
                'message' => 'Warehouse not found for the given location and district!',
            ], 404);
        }

        // Find the associated product by name
        $product = Product::where('name_en', $validatedData['product_name'])->first();

        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found!',
            ], 404);
        }

        // Update the inventory record
        $inventory->update([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => $validatedData['quantity_inhand'],
        ]);

        // Optionally handle quantity_sold in a pivot table if necessary
        if (isset($validatedData['quantity_sold'])) {
            // Assume we have a method to update the quantity_sold in the pivot table
            $inventory->updateQuantitySold($validatedData['quantity_sold']);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Inventory updated successfully!',
            'data' => $inventory->load(['product', 'warehouse']), // Load relations for better response
        ]);
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
        return $this->Api_Response(message: 'Inventory deleted successfuly !');
    }
}
