<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM blood_requests WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Request marked as completed and removed.";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
