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
    $requester_name = $_POST['requester_name'];
    $contact_number = $_POST['contact_number'];
    $patient_name = $_POST['patient_name'];
    $blood_group = $_POST['blood_group'];
    $units_needed = $_POST['units_needed'];
    $hospital = $_POST['hospital'];
    $date_needed = $_POST['date_needed'];

    $check_sql = "SELECT unit_count FROM blood_inventory WHERE blood_group = '$blood_group'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $available_units = $row['unit_count'];

        if ($available_units >= $units_needed) {
            $update_sql = "UPDATE blood_inventory SET unit_count = unit_count - $units_needed WHERE blood_group = '$blood_group'";

            if ($conn->query($update_sql) === TRUE) {
                $insert_sql = "INSERT INTO blood_requests (requester_name, contact_number, patient_name, blood_group, units_needed, hospital, date_needed)
                               VALUES ('$requester_name', '$contact_number', '$patient_name', '$blood_group', $units_needed, '$hospital', '$date_needed')";

                if ($conn->query($insert_sql) === TRUE) {
                    echo json_encode(["message" => "Request accepted. We will contact you soon for delivery!!"]);
                } else {
                    echo json_encode(["message" => "Error inserting request details: " . $conn->error]);
                }
            } else {
                echo json_encode(["message" => "Error updating blood inventory: " . $conn->error]);
            }
        } else {
            
            echo json_encode(["message" => "Insufficient blood units for the selected blood type. Available units: $available_units"]);
        }
    } else {
        
        echo json_encode(["message" => "Blood group not found in inventory."]);
    }

    $conn->close();
}
?>
