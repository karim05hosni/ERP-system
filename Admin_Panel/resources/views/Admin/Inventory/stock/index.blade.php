@extends('Admin.layouts.parent')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@php
    $token = auth()->user()->createToken('inventoryAccess')->plainTextToken;
    session(['api_token' => $token]); // Store it in the session
@endphp
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- @csrf --}}
    <div id="editinventoryModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="editinventoryFormContainer">
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
        <h1>Inventory Stock Management</h1>
        <button id="addWarehouse">Add Warehouse</button>
        <table id="inventoryTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity In Hand</th>
                    <th>Warehouse Location</th>
                    <th>Warehouse District</th>
                    <th>Quantity Sold</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be appended here dynamically -->
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
<script src="{{url('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
--}}
    <script>
        $(document).ready(function() {
            const API_TOKEN = '{{ session('api_token') }}';

            $.ajaxSetup({
                headers: {
                    'Authorization': `Bearer ${API_TOKEN}`
                }
            });

            $(document).ready(function() {
                // Function to load inventory data
                function loadInventory() {
                    $.ajax({
                        url: '/api/inventory', // Your API endpoint
                        method: 'GET',
                        success: function(response) {
                            let rows = '';
                            response.User_api.data.forEach(inventory => {
                                rows += `
                        <tr>
                            <td>${inventory.id}</td>
                            <td>${inventory.product_name}</td>
                            <td>${inventory.quantity_inhand}</td>
                            <td>${inventory.warehouse_location}</td>
                            <td>${inventory.warehouse_district}</td>
                            <td>${inventory.quantity_sold}</td>
                            <td>
                                <button class="editInventory" data-id="${inventory.id}">Edit</button>
                                <button class="deleteInventory" data-id="${inventory.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                            });
                            $('#inventoryTable tbody').html(rows);
                        },
                        error: function(error) {
                            console.error("Error fetching inventory", error);
                        }
                    });
                }

                // Initial load
                loadInventory();

                // Handle delete button click
                $(document).on('click', '.deleteInventory', function() {
                    const inventoryId = $(this).data('id');
                    const url = `/api/inventory/destroy/${inventoryId}`; // Adjust as per your route

                    if (confirm("Are you sure you want to delete this inventory?")) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            success: function() {
                                alert('Inventory deleted successfully!');
                                loadInventory(); // Reload table after deletion
                            },
                            error: function(error) {
                                console.error("Error deleting inventory", error);
                                alert('Failed to delete inventory. Please try again.');
                            }
                        });
                    }
                });
            });

        });

        // Open Edit form
        $(document).on('click', '.editInventory', function() {
            const inventoryId = $(this).data('id');
            const url = `/inventory/edit/${inventoryId}`; // Replace with your route

            // Show a loading indicator or message
            $('#editinventoryFormContainer').html('<p>Loading...</p>');
            $('#editinventoryModal').show();

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    // Load the response HTML into the modal
                    $('#editinventoryFormContainer').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading edit form:', error);
                    $('#editinventoryFormContainer').html(
                        '<p>Error loading form. Please try again later.</p>'
                    );
                }
            });
        });


        // Save the edited inventory
        $(document).on('click', '#saveinventory', function() {
            const inventoryId = $('#editinventoryForm input[name="id"]').val(); // Get inventory ID
            const url = `/api/inventory/update-inventory/${inventoryId}`; // API route
            const formData = $('#editinventoryForm').serialize(); // Serialize form data
            
            $.ajax({
                url: url,
                method: 'POST', // Use PUT for updating resources
                data: formData,
                success: function(response) {
                    alert('inventory updated successfully!');

                    // Hide the modal
                    $('#editinventoryModal').hide();

                    // Reload the inventory list
                    loadInventory();
                },
                error: function(xhr, status, error) {
                    console.error('Error updating warehouse:', error);
                    alert('Failed to update warehouse. Please try again.');
                }
            });
        });
    </script>
@endsection
