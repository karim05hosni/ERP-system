<form id="editWarehouseForm">
    @csrf
    <input type="hidden" name="id" value="{{ $warehouse->id }}">
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $warehouse->name }}" required>
    </div>
    <div>
        <label for="location">Location:</label>
        <input type="text" name="location" value="{{ $warehouse->location }}" required>
    </div>
    <div>
        <label for="storage">Storage:</label>
        <input type="number" name="storage" value="{{ $warehouse->storage }}" required>
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="{{ $warehouse->phone }}" required>
    </div>
    <div>
        <label for="district">District:</label>
        <input type="text" name="district" value="{{ $warehouse->district }}" required>
    </div>
    <button type="button" id="saveWarehouse">Save</button>
</form>
{{-- <script>
    $(document).on('click', '#saveWarehouse', function() {
    const warehouseId = $('#editWarehouseForm input[name="id"]').val(); // Get warehouse ID
    const url = `/api/warehouse/edit-warehouse/${warehouseId}`; // API route
    const formData = $('#editWarehouseForm').serialize(); // Serialize form data

    $.ajax({
        url: url,
        method: 'POST', // Use PUT for updating resources
        data: formData,
        success: function(response) {
            alert('Warehouse updated successfully!');
            $('#editWarehouseModal').hide();
        },
        error: function(xhr, status, error) {
            console.error('Error updating warehouse:', error);
            alert('Failed to update warehouse. Please try again.');
        }
    });
});
</script> --}}
