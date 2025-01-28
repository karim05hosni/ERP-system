<form id="addInventoryForm">
    @csrf
    @csrf
    <input type="hidden" name="id" value="">
    <div>
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="">
    </div>
    <div>
        <label for="quantity_inhand">Quantity In Hand:</label>
        <input type="number" id="quantity_inhand" name="quantity_inhand" value="">
    </div>
    {{-- <div>
        <label for="min_stock">Minimum Stock:</label>
        <input type="number" id="min_stock" name="min_stock" value="">
    </div> --}}
    <div>
        <label for="warehouse_location">Warehouse Location:</label>
        <input type="text" id="warehouse_location" name="warehouse_location" value="">
    </div>
    <div>
        <label for="warehouse_district">Warehouse District:</label>
        <input type="text" id="warehouse_district" name="warehouse_district" value="">
    </div>
    <div>
        <label for="quantity_sold">Quantity Sold:</label>
        <input type="number" id="quantity_sold" name="quantity_sold" value="">
    </div>
    <button type="button" id="insertInventory">Save</button>
</form>