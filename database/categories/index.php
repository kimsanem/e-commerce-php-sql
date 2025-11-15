<?php
session_start();
include '../database.php';

// Fetch all categories
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

include '../layouts/header.php';
?>

<h1>Categories</h1>
<a href="create.php" class="btn btn-success mb-3">Create New Category</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No categories found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../layouts/footer.php'; ?>