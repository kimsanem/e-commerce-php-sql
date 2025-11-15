<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $password, $id);

    if ($stmt->execute()) {
        header('Location: index.html');
    } else {
        echo "Error: " . $stmt->error;
    }
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

include '../layouts/header.php';
?>

<h1>Edit User</h1>
<?php include 'form.php'; ?>

<?php include '../layouts/footer.php'; ?>