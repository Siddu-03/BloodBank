<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Requests</title>
    <link rel="stylesheet" href="pendingreq-style.css">
</head>

<body>

<h1>Blood Requests</h1>

<table border="1">
    <tr>
        <th>Request ID</th>
        <th>Accident ID</th>
        <th>Required Blood Type</th>
        <th>Units</th>
        <th>Status</th>
        <th>Request Time</th>
    </tr>

    <?php
    $query = "SELECT * FROM EmergencyBloodRequest WHERE Status = 'Pending'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['EmergencyRequestID']}</td>
                    <td>{$row['AccidentID']}</td>
                    <td>{$row['RequiredBloodType']}</td>
                    <td>{$row['RequiredUnits']}</td>
                    <td>{$row['Status']}</td>
                    <td>{$row['RequestTime']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No pending requests found.</td></tr>";
    }

    $conn->close();
    ?>
</table>

<a href="bloodbank-dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

<script src="js/app.js"></script>
</body>
</html>
