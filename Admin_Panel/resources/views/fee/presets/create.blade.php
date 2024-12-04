{{-- resources/views/fee/presets/create.blade.php --}}
@extends('Admin.layouts.parent')
@section('title', 'products')
@section('css')
<!-- DataTables -->
  <link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="container">
    <h1>Create Fee Preset</h1>

    <!-- Form to Create a New Fee Preset -->
    <form action="{{ route('fee.presets.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="preset_name" class="form-label">Preset Name</label>
            <input type="text" class="form-control @error('preset_name') is-invalid @enderror" id="preset_name" name="preset_name" value="{{ old('preset_name') }}" required>
            @error('preset_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
