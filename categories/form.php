<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($user['name']) ? $user['name'] : ''; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>