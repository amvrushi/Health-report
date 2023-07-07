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

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $sql = "SELECT report_name, report_content FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($reportName, $reportContent);

    if ($stmt->fetch()) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $reportName . '"');
        echo $reportContent;
    } else {
        echo "No report found.";
    }
    $stmt->close();
} else {
    echo "Email ID is not provided.";
}
$conn->close();
