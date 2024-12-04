{{-- resources/views/fee/presets/edit.blade.php --}}
@extends('Admin.layouts.parent')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Service</h1>

        <form action="{{ route('fee.services.update', $feeService->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="service_name" class="form-label">Service Name</label>
                <input type="text" class="form-control" id="service_name" name="service_name" value="{{ $feeService->service_name }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('fee.services.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection