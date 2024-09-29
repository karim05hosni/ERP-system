<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Http\traits\Admin_Api_Response_Trait;
use App\Http\traits\Api_Response_Trait;
use App\Http\traits\media;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use Admin_Api_Response_Trait;
    use media;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_products()
    {
        // get data
        $products = Product::all();
        // $sub_categories = SubCategory::select('name_en', 'id');
        return $this->Api_Response(message: 'All Products Retrieved Successfully', data: compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProductsRequest $request)
    {
        // validation
        $data = $request->except('_token', 'image','create');
        $photo_name = $this->UploadPhoto($request->image, 'products');
        // dd($photo_name);
        $data['image'] = $photo_name;
        // dd($data);
        $insert = Product::create($data);
        if ($insert) {
            return $this->Api_Response(message: 'Product Added Successfully', data: compact('insert'));
        } else {
            return $this->Api_Response(message: 'Failed to Add Product', status: 400);
        }
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
    public function update(UpdateProductsRequest $request, $id)
    {
        $data = $request->except('_token', 'image', '_method');
        // move image
        if($request->has('image')){
            $this->DelPhoto($request->id, 'products');
            // dd($old_photo_name);
            $upload = $this->UploadPhoto($request->image, 'products');
            $data['image'] = $upload;
        }
        $update=Product::find($id)->update($data);
        if ($update){
            return response()->json($this->Api_Response(message: 'Product Updated Successfully', data: compact('update')));
        } else {
            return response()->json($this->Api_Response(message: 'Failed to Update Product', status: 400));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $old_photo_name = Product::find($id)->image;
        $photo_path = public_path("dist\\img\\products\\");
        if($old_photo_name){
            // dd(file_exists($photo_path . $old_photo_name . '.jpg'));
            if(file_exists($photo_path . $old_photo_name . '.jpg')){
                // dd('yy');
                unlink($photo_path . $old_photo_name . '.jpg');
            }
        }
        $deleted = Product::find($id)->delete();
        if ($deleted) {
            // return $this->Api_Response(message: 'Product Deleted Successfuly !', data:compact('deleted'));
            return response()->json($this->Api_Response(message: 'Product Deleted Successfuly !', data:compact('deleted')));
        } else {
            return response()->json($this->Api_Response(message: 'Failed to Delete Product', status: 400));
        }
        // return $this->Api_Response(message:)
    }
}
