<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" 
               value="<?php echo isset($product['name']) ? htmlspecialchars($product['name']) : ''; ?>" 
               required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo isset($product['description']) ? htmlspecialchars($product['description']) : ''; ?></textarea>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price ($)</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" 
               value="<?php echo isset($product['price']) ? htmlspecialchars($product['price']) : ''; ?>" 
               required>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category ID</label>
        <input type="number" class="form-control" id="category_id" name="category_id" 
               value="<?php echo isset($product['category_id']) ? htmlspecialchars($product['category_id']) : ''; ?>" 
               required>
    </div>

    <button type="submit" class="btn btn-primary">Save Product</button>
</form>
