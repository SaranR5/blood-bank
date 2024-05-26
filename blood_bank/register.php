<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood-group'];
    $age = $_POST['age'];
    $health_conditions = $_POST['health-conditions'];

    $sql = "INSERT INTO donors (name, phone, gender, blood_group, age, health_conditions)
            VALUES ('$name', '$phone', '$gender', '$blood_group', $age, '$health_conditions')";

    if ($conn->query($sql) === TRUE) {
        $update_sql = "INSERT INTO blood_inventory (blood_group, unit_count) VALUES ('$blood_group', 1)
                       ON DUPLICATE KEY UPDATE unit_count = unit_count + 1";

        if ($conn->query($update_sql) === TRUE) {
            echo json_encode(["message" => "Thanks for saving a life, We will contact you soon!!"]);
        } else {
            echo json_encode(["message" => "Error updating blood inventory: " . $conn->error]);
        }
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }

    $conn->close();
}
?>
