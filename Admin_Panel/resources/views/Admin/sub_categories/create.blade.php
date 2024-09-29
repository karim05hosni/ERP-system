@extends('Admin.layouts.parent')
{{-- @section('title', 'create product') --}}
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Create Sub-Category</h2>
        @if (isset($success))
            <?php echo $success; ?>
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

        <form action="{{ route('sub_categories.add') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nameEn">Name en</label>
                    <input type="text" name='name_en' class="form-control" id="nameEn"
                        placeholder="Enter product name in English" value="{{old('name_en')}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="nameAr">Name ar</label>
                    <input type="text" name="name_ar" class="form-control" id="nameAr"
                        placeholder="Enter product name in Arabic" value="{{old('name_en')}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name='status' class="form-control" id="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="subcategories">Category</label>
                    <select name="category_id" id="subcategories" class="form-control">
                        @foreach ($categories as $cate)
                            <option value="{{ $cate->id }}">{{ $cate->name_en }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
