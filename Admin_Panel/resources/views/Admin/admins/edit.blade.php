@extends('Admin.layouts.parent')
{{-- @section('title', 'create product') --}}
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Admin</h2>
        @if (isset($success))
            <?php echo $success; ?>
        @endif
        <form action="{{route('admins.update', $admin->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- @method('put') --}}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" name='name' class="form-control @error('name') is-invalid @enderror"
                        id="name" placeholder="Enter product name in English" value="{{$admin->name}}">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="role">Role</label>
                    <input type="text" name="role" class="form-control @error('role') is-invalid @enderror"
                        id="role" placeholder="Enter product name in Arabic" value="{{$admin->role}}">
                    @error('role')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <label class="mr-4" for="f">permissions</label>
                <div class="form-group">
                    {{-- @dd($permissions) --}}
                    <div class="gr">
                        @foreach ($permissions as $permission)
                        <div id="f" class="form-check">
                                {{-- @dd($permission->name) --}}
                                <input type="checkbox" name="permissions[]" class=" form-check-input @error('permissions') is-invalid @enderror"
                                    id="permissions" {{$admin->permissions->contains($permission->id) ? 'checked' : ''}} placeholder="Enter product permissions" value="{{ $permission->id }}">
                                <label class="form-check-label permission-label" for="permissions">{{ $permission->name }}</label>
                                @error('permissions')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <br>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
<style>
    .permission-label {
        font-size: 16px;
        margin: 5px;
    }
    .form-check-input {
  width: 18px; /* adjust the width to your desired size */
  height: 18px; /* adjust the height to your desired size */
  margin: 8px; /* add some margin to make it look better */
}

.form-check-input:checked {
  background-color: #007bff; /* change the background color when checked */
  border-color: #007bff; /* change the border color when checked */
}

.form-check-input:focus {
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* add a focus effect */
}
.gr {
    display: grid;
  grid-template-columns: repeat(4, 1fr);/* 4 columns, each taking 1 fractional unit of space */
  grid-template-rows: 2; /* 2 rows */
  gap: 10px; /* add a gap between grid cells */
}
.form-row>label {
    font-size: 18px ;
}
</style>