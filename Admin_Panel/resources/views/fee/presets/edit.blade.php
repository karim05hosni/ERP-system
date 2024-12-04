{{-- resources/views/fee/presets/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Fee Preset</h1>

    <!-- Form to Edit an Existing Fee Preset -->
    <form action="{{ route('fee.presets.update', $preset->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="preset_name" class="form-label">Preset Name</label>
            <input type="text" class="form-control @error('preset_name') is-invalid @enderror" id="preset_name" name="preset_name" value="{{ old('preset_name', $preset->name) }}" required>
            @error('preset_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
