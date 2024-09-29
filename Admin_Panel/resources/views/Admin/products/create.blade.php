@extends('Admin.layouts.parent')
{{-- @section('title', 'create product') --}}
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Create Product</h2>
        @if (isset($success))
            <?php echo $success; ?>
        @endif
        <form action="{{ route('products.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nameEn">Name en</label>
                    <input type="text" name='name_en' class="form-control @error('name_en') is-invalid @enderror"
                        id="nameEn" placeholder="Enter product name in English" value="{{old('name_en')}}">
                    @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="nameAr">Name ar</label>
                    <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                        id="nameAr" placeholder="Enter product name in Arabic" value="{{old('name_ar')}}">
                    @error('name_ar')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="price">Price</label>
                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror"
                        id="price" placeholder="Enter product price" value="{{old('price')}}">
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name='status' class="form-control @error('status') is-invalid @enderror" id="status">
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
                    <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                        id="quantity" placeholder="Enter product quantity" value="{{old('quantity')}}">
                    @error('quantity')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="subcategories">Subcategory</label>
                    <select name="subcate_id" id="subcategories"
                        class="form-control @error('subcate_id') is-invalid @enderror">
                        @foreach ($sub_categories as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name_en }}</option>
                        @endforeach
                    </select>
                    @error('subcate_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="brands">Brand</label>
                    <select name="brand_id" id="brands" class="form-control @error('Brand') is-invalid @enderror">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name_en }}</option>
                        @endforeach
                        <option value="{{ null }}">none</option>
                    </select>
                    @error('brand_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="descEn">Description en</label>
                    <textarea class="form-control" name="desc_en" id="descEn" rows="3" value="{{old('desc_en')}}" placeholder="Enter description in English"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="descAr">Description ar</label>
                    <textarea class="form-control" name="desc_ar" id="descAr" value="{{old('desc_ar')}}" rows="3" placeholder="Enter description in Arabic"></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                        id="image" placeholder="image" value="{{old('image')}}">
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="cost_per_unit">Cost per unit</label>
                <input type="text" name="cost_per_unit" class="form-control @error('cost_per_unit') is-invalid @enderror"
                    id="cost_per_unit" placeholder="Enter product cost_per_unit" value="{{old('cost_per_unit')}}">
                @error('cost_per_unit')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
