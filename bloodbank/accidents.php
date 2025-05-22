<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "Siddu@1206", "blood_bank");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $severity = $_POST['severity'];
    $casualties = $_POST['casualties'];
    $reportedBy = $_POST['reportedBy'];

    $stmt = $conn->prepare("INSERT INTO AccidentReport (Location, Latitude, Longitude, Severity, CasualtyCount, ReportedBy) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sddsis", $location, $latitude, $longitude, $severity, $casualties, $reportedBy);

    if ($stmt->execute()) {
        echo "<script>alert('Accident reported successfully!'); window.location.href='accidents.php';</script>";
    } else {
        echo "<script>alert('Failed to report accident.'); window.location.href='accidents.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Accident</title>
    <link rel="stylesheet" href="accidents-style.css"> <!-- Keep your original CSS file -->
</head>
<body>

    <div class="accident-form-container">
        <h1>Report an Accident</h1>

        <form method="POST" action="accidents.php" id="accident-form">
            <div class="form-group">
                <label for="location">Accident Location:</label>
                <input type="text" id="location" name="location" required>
            </div>

            <div class="form-group">
                <label for="latitude">Latitude:</label>
                <input type="number" step="any" id="latitude" name="latitude" required>
            </div>

            <div class="form-group">
                <label for="longitude">Longitude:</label>
                <input type="number" step="any" id="longitude" name="longitude" required>
            </div>

            <div class="form-group">
                <label for="severity">Severity:</label>
                <select id="severity" name="severity" required>
                    <option value="">--Select Severity--</option>
                    <option value="Low">Low</option>
                    <option value="Moderate">Moderate</option>
                    <option value="Severe">Severe</option>
                </select>
            </div>

            <div class="form-group">
                <label for="casualties">Number of Casualties:</label>
                <input type="number" id="casualties" name="casualties" required>
            </div>

            <div class="form-group">
                <label for="reportedBy">Reported By:</label>
                <input type="text" id="reportedBy" name="reportedBy" required>
            </div>

            <button type="submit" class="submit-btn">Submit Report</button>
        </form>
    </div>

</body>
</html>
