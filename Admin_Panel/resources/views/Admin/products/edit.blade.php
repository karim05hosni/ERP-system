@extends('Admin.layouts.parent')
{{-- @section('title', 'create product') --}}
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Product</h2>
    @if (isset($success))
        @php
            echo $success;
        @endphp
    @endif
    <form method="POST" action="{{route('products.update', $product->id)}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nameEn">Name en</label>
                <input type="text" name='name_en' value="{{$product->name_en}}" class="form-control" id="nameEn" placeholder="Enter product name in English">
                @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="nameAr">Name ar</label>
                
                <input type="text" name='name_ar' value="{{$product->name_ar}}" class="form-control" id="nameAr" placeholder="Enter product name in Arabic">
                @error('name_ar')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="price">Price</label>
                <input type="text" name="price"value="{{$product->price}}" class="form-control" id="price" placeholder="Enter product price">
                @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="status">Status</label>
                <select name="status" class="form-control" id="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                
                </select>
                @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" value="{{$product->quantity}}" class="form-control" id="quantity" placeholder="Enter product quantity">
            </div>
            <div class="form-group col-md-6">
                <label for="subcategories">Subcategories</label>
                <select name="subcate_id" id="subcategories" class="form-control">
                    @foreach ($sub_categories as $sub)
                        <option {{$product->subcate_id == $sub->id ? 'selected' : ''}} value="{{$sub->id}}">{{$sub->name_en}}</option>
                    @endforeach
                </select>
                @error('subcate_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="brands">Brands</label>
                <select name="brand_id" id="brands" class="form-control">
                    @foreach ($brands as $brand)
                    <option  {{$product->brand_id == $brand->id ? 'selected' : ''}} value="{{$brand->id}}">{{$brand->name_en}}</option>
                    @endforeach
                    <option {{$product->brand_id == null ? 'selected' : '' }} value="{{null}}">None</option>
                </select>
                @error('brand_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="descEn">Description en</label>
                <textarea class="form-control" value="{{$product->desc_en}}" id="descEn" rows="3" placeholder="Enter description in English"></textarea>
                
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="descAr">Description ar</label>
                <textarea class="form-control" value="{{$product->desc_ar}}" id="descAr" rows="3" placeholder="Enter description in Arabic"></textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="image">Image</label>
                <input  type="file" value="" name="image" class="form-control" id="image" placeholder="Enter image URL">
                <div class="col-4">
                    @php
                        $ex='';
                    @endphp
                    @if (!str_contains($product->image, '.'))
                        @php
                            $ex = '.jpg';
                        @endphp
                    @endif
                    <img src="{{url('dist/img/products/'.$product->image.$ex)}}" alt="" class="" style="width: 350px">
                </div>
                @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary warning">Update</button>
    </form>
</div>
@endsection
