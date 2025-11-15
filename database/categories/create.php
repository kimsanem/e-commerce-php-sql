<?php
    include '../database.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];

        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            header('Location: index.html');
        } else {
            echo "Error: " . $stmt->error;
        }
    }
include '../layouts/header.php';
?>

<h1>Create Categories</h1>
<?php include 'form.php'; ?>

<?php include '../layouts/footer.php'; ?>