<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, category_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $description, $price, $category_id);

    if ($stmt->execute()) {
        header('Location: index.html');
    }else {
        echo "Error: " . $stmt->error;
    }
}

include '../layouts/header.php';
?>

<h1>Create User</h1>
<?php include 'form.php'; ?>

<?php include '../layouts/footer.php'; ?>