<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];

    $stmt = $conn->prepare("UPDATE categories SET name=?, WHERE id=?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        header('Location: index.html');
    } else {
        echo "Error: " . $stmt->error;
    }
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM categories WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

include '../layouts/header.php';
?>

<h1>Edit User</h1>
<?php include 'form.php'; ?>

<?php include '../layouts/footer.php'; ?>