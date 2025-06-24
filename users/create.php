<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        header('Location: index.php');
    }else {
        echo "Error: " . $stmt->error;
    }
}

include '../layouts/header.php';
?>

<h1>Create User</h1>
<?php include 'form.php'; ?>

<?php include '../layouts/footer.php'; ?>