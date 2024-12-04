<form id="editinventoryForm">
    @csrf
    <input type="hidden" name="id" value="{{ $data['id'] }}">
    <div>
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="{{ $data['product_name'] }}" readonly>
    </div>
    <div>
        <label for="quantity_inhand">Quantity In Hand:</label>
        <input type="number" id="quantity_inhand" name="quantity_inhand" value="{{ $data['quantity_inhand'] }}">
    </div>
    <div>
        <label for="warehouse_location">Warehouse Location:</label>
        <input type="text" id="warehouse_location" name="warehouse_location" value="{{ $data['warehouse_location'] }}" readonly>
    </div>
    <div>
        <label for="warehouse_district">Warehouse District:</label>
        <input type="text" id="warehouse_district" name="warehouse_district" value="{{ $data['warehouse_district'] }}" readonly>
    </div>
    <div>
        <label for="quantity_sold">Quantity Sold:</label>
        <input type="number" id="quantity_sold" name="quantity_sold" value="{{ $data['quantity_sold'] }}">
    </div>
    <button type="button" id="saveinventory">Save</button>
</form>
