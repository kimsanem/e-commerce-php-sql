<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category_id=? WHERE id=?");
    $stmt->bind_param("sssdi", $name, $description, $price, $category_id, $id);

    if ($stmt->execute()) {
        header('Location: index.html');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

include '../layouts/header.php';
?>

<h1>Edit Product</h1>
<?php include 'form.php'; ?>

<?php include '../layouts/footer.php'; ?>
