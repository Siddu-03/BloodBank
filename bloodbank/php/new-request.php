<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bloodType = $_POST["bloodType"];
    $quantity = intval($_POST["quantity"]);
    $accidentID = isset($_POST["accidentID"]) ? intval($_POST["accidentID"]) : 1; // replace or fetch dynamically
    $bloodCenterID = isset($_POST["bloodCenterID"]) ? intval($_POST["bloodCenterID"]) : 1; // replace or fetch dynamically
    $status = 'Pending';

    $stmt = $conn->prepare("INSERT INTO EmergencyBloodRequest (AccidentID, RequiredBloodType, RequiredUnits, NearestBloodCenterID, Status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isiss", $accidentID, $bloodType, $quantity, $bloodCenterID, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Emergency blood request submitted successfully.'); window.location.href='thankyou.php';</script>";
    } else {
        echo "<script>alert('Submission failed: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Emergency Blood Request - Hospital</title>
    <link rel="stylesheet" href="newrequest-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        function validateRequestForm() {
            const bloodType = document.getElementById("bloodType").value;
            const quantity = document.getElementById("quantity").value;
            if (bloodType === "" || quantity === "" || parseInt(quantity) <= 0) {
                alert("Please fill all required fields correctly.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="progress-container">
        <div class="progress-bar" id="formProgress"></div>
    </div>

    <div class="form-header">
        <h2>Emergency Blood Request</h2>
        <p>Please complete all required fields to submit your request</p>
    </div>

    <form onsubmit="return validateRequestForm()" method="POST" action="">
        <div class="form-section">
            <!-- Hospital Info (just for display, not used in DB here) -->
            <label for="hospitalName">Hospital Name:</label><br>
            <input type="text" id="hospitalName" name="hospitalName" required><br><br>

            <label for="contactPerson">Contact Person:</label><br>
            <input type="text" id="contactPerson" name="contactPerson" required><br><br>

            <label for="contactNumber">Contact Number:</label><br>
            <input type="tel" id="contactNumber" name="contactNumber" required><br><br>

            <label for="email">Email Address:</label><br>
            <input type="email" id="email" name="email"><br><br>

            <label for="hospitalAddress">Hospital Address:</label><br>
            <textarea id="hospitalAddress" name="hospitalAddress" rows="3" cols="50"></textarea><br><br>
        </div>

        <div class="form-section">
            <!-- Emergency blood request -->
            <label for="bloodType">Required Blood Type:</label><br>
            <select id="bloodType" name="bloodType" required>
                <option value="">-- Select --</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select><br><br>

            <label for="quantity">Quantity (in units):</label><br>
            <input type="number" id="quantity" name="quantity" min="1" required><br><br>

            <label for="urgency">Urgency Level:</label><br>
            <select id="urgency" name="urgency" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
                <option value="Critical">Critical</option>
            </select><br><br>

            <label for="requiredDate">Date Blood is Needed:</label><br>
            <input type="date" id="requiredDate" name="requiredDate" required><br><br>

            <label for="reason">Reason for Request / Patient Condition:</label><br>
            <textarea id="reason" name="reason" rows="4" cols="50" required></textarea><br><br>
        </div>

        <!-- Hidden fields for linking to actual tables -->
        <input type="hidden" name="accidentID" value="1"> <!-- Replace with dynamic ID if needed -->
        <input type="hidden" name="bloodCenterID" value="1"> <!-- Replace with dynamic nearest blood center ID -->

        <button type="submit">Submit Blood Request</button>
    </form>
     <div class="header-actions">
          <a href="hospital-dashboard.php" class="header-link"><i class="fas fa-home"></i> Home</a>
        </div>

    <script src="js/app.js"></script>
</body>
</html>
