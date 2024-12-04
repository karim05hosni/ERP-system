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
        <h1 class="mb-4">Create New Service</h1>

        <form action="{{ route('fee.services.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="service_name" class="form-label">Service Name</label>
                <input type="text" class="form-control" id="service_name" name="service_name" required>
            </div>
            <div class="mb-3">
                <label for="service_name" class="form-label">Preset</label>
                <select name="preset_id" id="presets" class="form-control">
                    @foreach($presets as $preset)
                    <option value="{{$preset->id}}">{{$preset->name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="thresholds">Thresholds:</label>
                <button type="button" id="addThreshold">Add Threshold</button>
                <div id="thresholds">
                    <div class="threshold">
                        <input type="number" name="thresholds[0][min_value]" placeholder="min_value" required>
                        <input type="number" name="thresholds[0][max_value]" placeholder="max_value" required>
                        <input type="text" name="thresholds[0][fee_percentage]" placeholder="fee_percentage" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('fee.services.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
        
    </div>
@endsection
@section('scripts')
<script>
let thresholdCount = 1;

document.getElementById('addThreshold').addEventListener('click', function() {
    const thresholdContainer = document.getElementById('thresholds');
    const thresholdHtml = `
        <div class="threshold">
            <input type="number" name="thresholds[${thresholdCount}][min_value]" placeholder="min_value" required>
            <input type="number" name="thresholds[${thresholdCount}][max_value]" placeholder="max_value" required>
            <input type="text" name="thresholds[${thresholdCount}][fee_percentage]" placeholder="fee_percentage" required>
            <button type="button" class="removeThreshold">Remove</button>
        </div>
    `;
    thresholdContainer.insertAdjacentHTML('beforeend', thresholdHtml);
    thresholdCount++;

    const removeThresholdButtons = document.querySelectorAll('.removeThreshold');
    removeThresholdButtons.forEach(button => {
        button.addEventListener('click', function() {
            button.parentNode.remove();
        });
    });
});
</script>
@endsection