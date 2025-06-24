<?php
session_start();
include '../database.php';

// Fetch all products with category names
$sql = "SELECT p.id, p.name, p.description, p.price, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id";
$result = $conn->query($sql);

include '../layouts/header.php';
?>

<h1>Products</h1>
<a href="create.php" class="btn btn-success mb-3">Create New Product</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No products found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../layouts/footer.php'; ?>