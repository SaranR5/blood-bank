<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM blood_inventory";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["blood_group"] . "</td>";
        echo "<td>" . $row["unit_count"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>No records found</td></tr>";
}

$conn->close();
?>
