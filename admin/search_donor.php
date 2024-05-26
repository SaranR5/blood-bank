<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$phone = $_POST['phone'];

$sql = "SELECT * FROM donors WHERE phone='$phone'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["blood_group"] . "</td>";
        echo "<td>" . $row["age"] . "</td>";
        echo "<td>" . $row["health_conditions"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}

$conn->close();
?>
