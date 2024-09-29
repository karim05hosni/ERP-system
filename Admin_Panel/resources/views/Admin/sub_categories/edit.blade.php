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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sub_categories.update', $sub_category->id) }}">
            @csrf
            @method('put')

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nameEn">Name en</label>
                    <input type="text" name='name_en' value="{{ $sub_category->name_en }}" class="form-control"
                        id="nameEn" placeholder="Enter sub_category name in English">
                </div>
                <div class="form-group col-md-6">
                    <label for="nameAr">Name ar</label>
                    <input type="text" name='name_ar' value="{{ $sub_category->name_ar }}" class="form-control"
                        id="nameAr" placeholder="Enter sub_category name in Arabic">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="subcategories">Category</label>
                    <select name="category_id" id="subcategories" class="form-control">
                        @foreach ($categories as $cate)
                            <option {{ $sub_category->category_id == $cate->id ? 'selected' : '' }}
                                value="{{ $cate->id }}">{{ $cate->name_en }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary warning">Update</button>
        </form>
    </div>
@endsection
