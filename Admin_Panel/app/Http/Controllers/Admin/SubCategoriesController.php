<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\sub_category\AddSubCategoriesRequest;
use App\Http\Requests\sub_category\UpdateSubCategoriesRequest;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // get data
        $sub_categories = SubCategory::all();
        // print_r($products);
        $categories = DB::table('category')
        ->where('status', 1)
        ->select('name_en', 'id')
        ->get();
        // $brands = DB::table('brands')
        // ->where('status', '=', 1)
        // ->select('name_en', 'id')
        // ->get();
        // pass data to view
        return view('Admin.sub_categories.sub_categories', compact('sub_categories', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('category')
        ->where('status', 1)
        ->select('name_en', 'id')
        ->get();
        return view('Admin.sub_categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(AddSubCategoriesRequest $request)
    {
        // dd($request->all());
        $data = $request->except('_token');
        $insert = SubCategory::create($data);
        if($insert){
            $success = "<div class='alert alert-success'>Created Successfuly!</div>";
        }
        return redirect()->route('sub_categories.index')->with(['success' => $success]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // required data for page
        $sub_category = SubCategory::where('id', $id)->first();
        $categories = DB::table('category')
        ->where('status', '=', 1)
        ->select('name_en', 'id')
        ->get();
        // $product = DB::table('products')->where('id',$id)->first();
        return view('Admin.sub_categories.edit', compact('sub_category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubCategoriesRequest $request, $id){
        $data = $request->except('_token', '_method');
        $update=SubCategory::find($id)->update($data);
        // dd($update);
        if($update == 1){
            $success = 1;
        } else {
            $success = 0;
        }
        return redirect()->route('sub_categories.index')->with(['success' => $success]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $deleted = SubCategory::find($id)->delete();
        
        if($deleted){
            $del = 1;
        } else {
            $del = 0;
        }
        return redirect()->back()->with($del);
    }
}
