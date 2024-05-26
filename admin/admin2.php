
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .dashboard-section {
            margin-bottom: 40px;
        }

        .dashboard-section h2 {
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            cursor: pointer;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #218838;
        }

        .search-section {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-section input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        .search-section button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-section button:hover {
            background-color: #0056b3;
        }

        .result-section {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Blood Donation Admin Dashboard</h1>

        <div class="dashboard-section">
            <h2>Blood Inventory</h2>
            <table>
                <thead>
                    <tr>
                        <th>Blood Group</th>
                        <th>Unit Count</th>
                    </tr>
                </thead>
                <tbody id="blood-inventory">
                    <?php include 'fetch_inventory.php'; ?>
                </tbody>
            </table>
        </div>

        <div class="dashboard-section">
            <h2>Blood Requests</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Requester Name</th>
                        <th>Contact Number</th>
                        <th>Patient Name</th>
                        <th>Blood Group Needed</th>
                        <th>Units Needed</th>
                        <th>Hospital</th>
                        <th>Date Needed</th>
                        <th>Request Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="blood-requests">
                    <?php include 'fetch_requests.php'; ?>
                </tbody>
            </table>
        </div>

        <div class="dashboard-section">
            <h2>Donors</h2>
            <div class="search-section">
                <input type="text" id="search-phone" placeholder="Enter donor phone number">
                <button onclick="searchDonor()">Search</button>
            </div>
            <div class="result-section">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Blood Group</th>
                            <th>Age</th>
                            <th>Health Conditions</th>
                        </tr>
                    </thead>
                    <tbody id="donor-details">
                        <?php include 'fetch_donors.php'; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
         function deleteRequest(id) {
            if (confirm('Are you sure you want to mark this request as completed?')) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_request.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById('response-message').innerText = xhr.responseText;
                        location.reload();
                    }
                };
                xhr.send('id=' + id);
            }
        }
        function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.querySelector("table");
        switching = true;
        dir = "asc"; 
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                var dateX = new Date(x.innerHTML);
                var dateY = new Date(y.innerHTML);
                if (dir == "asc") {
                    if (dateX > dateY) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (dateX < dateY) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }


        function searchDonor() {
            var phone = document.getElementById('search-phone').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'search_donor.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('donor-details').innerHTML = xhr.responseText;
                }
            };
            xhr.send('phone=' + phone);
        }
    </script>
</body>
</html>
