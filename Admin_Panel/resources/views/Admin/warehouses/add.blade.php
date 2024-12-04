<form id="addWarehouseForm">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" value="" required>
    </div>
    <div>
        <label for="location">Location:</label>
        <input type="text" name="location" value="" required>
    </div>
    <div>
        <label for="storage">Storage:</label>
        <input type="number" name="storage" value="" required>
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="" required>
    </div>
    <div>
        <label for="district">District:</label>
        <input type="text" name="district" value="" required>
    </div>
    <button type="button" id="insertWarehouse">Save</button>
</form>