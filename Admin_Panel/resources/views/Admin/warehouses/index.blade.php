@extends('Admin.layouts.parent')
@section('title', 'warehouses')
@section('css')
<!-- DataTables -->
  <link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@php
    $token = auth()->user()->createToken('WarehouseAccess')->plainTextToken;
        session(['api_token' => $token]); // Store it in the session
@endphp
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- @csrf --}}
<div id="editWarehouseModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="editWarehouseFormContainer">
            <!-- Edit form will be loaded here -->
        </div>
    </div>
</div>
<div id="addWarehouseModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="addWarehouseFormContainer">
            <!-- add form will be loaded here -->
        </div>
    </div>
</div>

<div class="container">
    <h1>Warehouse Management</h1>
    <button id="addWarehouse">Add Warehouse</button>
    <table id="warehouseTable" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>District</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Warehouses will be dynamically loaded here -->
        </tbody>
    </table>
</div>

@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{url('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script> --}}

<script>
    // Set up API token for all requests
const API_TOKEN = '{{ session("api_token") }}';
// const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
const CSRF_TOKEN = document.cookie
    .split('; ')
    .find(row => row.startsWith('XSRF-TOKEN='))
    ?.split('=')[1];

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'Authorization': `Bearer ${API_TOKEN}`
    }
});

// Function to load warehouses
function loadWarehouses() {
    $.ajax({
        url: '/api/warehouse', // Your API endpoint
        method: 'GET',
        success: function(response) {
            let rows = '';
            response.User_api.data.forEach(warehouse => {
                rows += `
                    <tr>
                        <td>${warehouse.id}</td>
                        <td>${warehouse.name}</td>
                        <td>${warehouse.location}</td>
                        <td>${warehouse.district}</td>
                        <td>${warehouse.storage}</td>
                        <td>
                            <button class="editWarehouse" data-id="${warehouse.id}">Edit</button>
                            <button class="deleteWarehouse" data-id="${warehouse.id}">Delete</button>
                        </td>
                    </tr>
                `;
            });
            $('#warehouseTable tbody').html(rows);
        },
        error: function(error) {
            console.error("Error fetching warehouses", error);
        }
    });
}

// Initial load
$(document).ready(function() {
    loadWarehouses();
});

// Open the edit form modal
$(document).on('click', '.editWarehouse', function() {
    const warehouseId = $(this).data('id');
    const url = `/warehouses/edit/${warehouseId}`; // Replace with your route

    // Show a loading indicator or message
    $('#editWarehouseFormContainer').html('<p>Loading...</p>');
    $('#editWarehouseModal').show();

    $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
            // Load the response HTML into the modal
            $('#editWarehouseFormContainer').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error loading edit form:', error);
            $('#editWarehouseFormContainer').html('<p>Error loading form. Please try again later.</p>');
        }
    });
});

// Save the edited warehouse
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
            
            // Hide the modal
            $('#editWarehouseModal').hide();

            // Reload the warehouse list
            loadWarehouses();
        },
        error: function(xhr, status, error) {
            console.error('Error updating warehouse:', error);
            alert('Failed to update warehouse. Please try again.');
        }
    });
});

// Close the modal
$(document).on('click', '.close', function() {
    $('#editWarehouseModal').hide();
});


// Open the add form modal
$(document).on('click', '#addWarehouse', function() {
    const url = `/warehouses/add`; // Replace with your route

    // Show a loading indicator or message
    $('#addWarehouseFormContainer').html('<p>Loading...</p>');
    $('#addWarehouseModal').show();

    $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
            // Load the response HTML into the modal
            $('#addWarehouseFormContainer').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error loading edit form:', error);
            $('#editWarehouseFormContainer').html('<p>Error loading form. Please try again later.</p>');
        }
    });
});


// Insert the  warehouse
$(document).on('click', '#insertWarehouse', function() {
    const url = `/api/warehouse/add-warehouse`; // API route
    const formData = $('#addWarehouseForm').serialize(); // Serialize form data

    $.ajax({
        url: url,
        method: 'POST', 
        data: formData,
        success: function(response) {
            alert('Warehouse add successfully!');
            // Hide the modal
            $('#addWarehouseModal').hide();

            // Reload the warehouse list
            loadWarehouses();
        },
        error: function(xhr, status, error) {
            console.error('Error adding warehouse:', error);
            alert('Failed to add warehouse. Please try again.');
        }
    });
});

$(document).on('click', '.close', function() {
    $('#addWarehouseModal').hide();
});



// Destroy
$(document).on('click', '.deleteWarehouse', function() {
    const warehouseId = $(this).data('id');
    const url = `/api/warehouse/destroy-warehouse/${warehouseId}`; // Replace with your API route

    // Confirm before deleting
    if (!confirm("Are you sure you want to delete this warehouse?")) {
        return;
    }

    $.ajax({
        url: url,
        method: 'DELETE',
        data: {
        "_token": "{{ csrf_token() }}",
        },
        // headers: {
        //     'X-CSRF-TOKEN': CSRF_TOKEN // Add CSRF token explicitly
        // },
        success: function(response) {
            alert('Warehouse deleted successfully!');

            // Reload the warehouse list
            loadWarehouses();

            // Optional: Show undo option
            showUndoOption(warehouseId);
        },
        error: function(xhr, status, error) {
            console.error('Error deleting warehouse:', error);
            alert('Failed to delete warehouse. Please try again.');
        }
    });
});
let recentlyDeletedWarehouse = null;
function showUndoOption(warehouseId) {
    const undoContainer = $('#undoContainer'); // A container for the undo message
    undoContainer.html(`
        <p>Warehouse deleted. <button id="undoDelete" data-id="${warehouseId}">Undo</button></p>
    `);
    undoContainer.show();

    // Automatically hide after 10 seconds
    setTimeout(() => {
        undoContainer.hide();
    }, 10000);
}

// // Handle undo click
// $(document).on('click', '#undoDelete', function() {
//     const warehouseId = $(this).data('id');

//     if (recentlyDeletedWarehouse) {
//         $.ajax({
//             url: '/api/warehouse', // Replace with your API route for creating a warehouse
//             method: 'POST',
//             data: recentlyDeletedWarehouse,
//             success: function(response) {
//                 alert('Warehouse restored successfully!');

//                 // Reload the warehouse list
//                 loadWarehouses();

//                 // Clear the undo container
//                 $('#undoContainer').hide();
//                 recentlyDeletedWarehouse = null;
//             },
//             error: function(xhr, status, error) {
//                 console.error('Error restoring warehouse:', error);
//                 alert('Failed to restore warehouse. Please try again.');
//             }
//         });
//     }
// });



</script>