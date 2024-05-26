<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM blood_requests ORDER BY date_needed ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["requester_name"] . "</td>";
        echo "<td>" . $row["contact_number"] . "</td>";
        echo "<td>" . $row["patient_name"] . "</td>";
        echo "<td>" . $row["blood_group"] . "</td>";
        echo "<td>" . $row["units_needed"] . "</td>";
        echo "<td>" . $row["hospital"] . "</td>";
        echo "<td>" . $row["date_needed"] . "</td>";
        echo "<td>" . $row["request_date"] . "</td>";
        echo '<td><button class="button" onclick="deleteRequest(' . $row["id"] . ')">Mark as Completed</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No records found</td></tr>";
}

$conn->close();
?>
