<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Http\traits\media;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class products extends Controller
{
    use media;
    public function all_products(){
        // Authorize
        Gate::authorize('has-permission', ['show-products']);
        // get data
        $products = DB::table('products')
        ->select('*')
            ->get();
        $sub_categories = DB::table('subcategories')
        ->where('status', 1)
        ->select('name_en', 'id')
        ->get();
        // pass data to view
        return view('Admin.products.products', compact('products', 'sub_categories'));
    }
    public function create(){
        // Authorize
        Gate::authorize('has-permission', ['create-products']);
        $sub_categories = DB::table('subcategories')
        ->where('status', 1)
        ->select('name_en', 'id')
        ->get();
        $brands = DB::table('brands')
        ->where('status', '=', 1)
        ->select('name_en', 'id')
        ->get();
        return view('Admin.products.create', compact('sub_categories', 'brands'));
    }
    public function add(AddProductsRequest $request){
        // authorize
        // dd($request->all());
        Gate::authorize('has-permission', ['create-products']);
        // validation
        // move image
        // move_uploaded_file($_FILES['image']['tmp_name'],__DIR__."\\..\\..\\..\\..\\..\\ecommerce\\assets\\img\\product\\$photo_name");
        // dd($_FILES);
        $data = $request->except('_token', 'image','create');
        $photo_name = $this->UploadPhoto($request->image, 'products');
        // dd($photo_name);
        $data['image'] = $photo_name;
        // dd($data);
        $insert = Product::create($data);
        // insert in purchases
        $insert_in_purchases = Purchase::create([
            'product_id' => $insert->id,
            'purchase_date' => now(),
            'quantity' => $insert->quantity,
            'unit_cost'=>$insert->cost_per_unit,
            'total_cost'=>$insert->cost_per_unit*$insert->quantity,
        ]) ;
        if($insert){
            $success = "<div class='alert alert-success'>Created Successfuly!</div>";
        }

        // required data for page
        $sub_categories = DB::table('subcategories')
        ->where('status', 1)
        ->select('name_en', 'id')
        ->get();
        $brands = DB::table('brands')
        ->where('status', '=', 1)
        ->select('name_en', 'id')
        ->get();

        return view('Admin.products.create', compact('success', 'sub_categories', 'brands'));
    }
    public function edit($id){
        // authorize
        Gate::authorize('has-permission', ['edit-products']);
        // required data for page
        $sub_categories = DB::table('subcategories')
        ->where('status', 1)
        ->select('name_en', 'id')
        ->get();
        $brands = DB::table('brands')
        ->where('status', '=', 1)
        ->select('name_en', 'id')
        ->get();
        $product = DB::table('products')->where('id',$id)->first();
        return view('Admin.products.edit', compact('sub_categories', 'brands', 'product'));
    }
    public function update(UpdateProductsRequest $request, $id){
        // authorize
        Gate::authorize('has-permission', ['edit-products']);
        // dd($request->all());
        $data = $request->except('_token', 'image', '_method');
        // dd($request->all());
        // move image
        if($request->has('image')){
            $this->DelPhoto($request->id, 'products');
            // dd($old_photo_name);
            $upload = $this->UploadPhoto($request->image, 'products');
            $data['image'] = $upload;
        }
        // move_uploaded_file($_FILES['image']['tmp_name'],__DIR__."\\..\\..\\..\\..\\..\\ecommerce\\assets\\img\\product\\$photo_name");
        // dd($_FILES);
        $update=DB::table('products')->where('id', $id)->update($data);
        // dd($update);
        if($update == 1){
            $success = 1;
        } else {
            $success = 0;
        }
        // print_r($products);
        // $product = DB::table('products')->where('id',$id)->first();
        // return view('Admin.products.products', compact('success', 'sub_categories', 'brands', 'products'));
        // return redirect()->back()->with('success', $success);
        return redirect()->route('products.all_products')->with(['success' => $success]);
    }
    public function delete($id){
        // authorize
        Gate::authorize('has-permission', ['delete-products']);
        // delete photo
        $old_photo_name = DB::table('products')->where('id',$id)->select('image')->first()->image;
            // dd($old_photo_name);
            $photo_path = public_path("dist\\img\\products\\");
            if($old_photo_name){
                // dd(file_exists($photo_path . $old_photo_name . '.jpg'));
                if(file_exists($photo_path . $old_photo_name . '.jpg')){
                    // dd('yy');
                    unlink($photo_path . $old_photo_name . '.jpg');
                }
            }
        $deleted = DB::table('products')->where('id', $id)->delete();
        
        if($deleted){
            $del = 1;
        } else {
            $del = 0;
        }
        return redirect()->back()->with($del);
    }
}
