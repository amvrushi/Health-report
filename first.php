<?php
// db
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'form';


$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $email = $_POST['email'];

    if (isset($_FILES['report'])) {
        $file = $_FILES['report'];
        $fileName = $file['name'];
        $fileTmpPath = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileContent = file_get_contents($fileTmpPath);


        $sql = "INSERT INTO users (name, age, weight, email, report_name, report_content) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissss", $name, $age, $weight, $email, $fileName, $fileContent);

        if ($stmt->execute()) {
            header('location:index.html?status=1');
        } else {
            header('location:index.html?status=2');
        }

        $stmt->close();
    } else {
        header('location:index.html?status=2');
    }
}
$conn->close();
