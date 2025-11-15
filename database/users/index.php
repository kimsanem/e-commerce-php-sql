<?php
session_start();
include '../database.php';

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

include '../layouts/header.php';
?>

<div class="d-flex justify-content-between">
  <h1>Users</h1>
  <a href="create.php" class="btn btn-success mb-3">Add New</a>
</div>

<?php include './table.php'; ?>

<?php include '../layouts/footer.php'; ?>