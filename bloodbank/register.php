<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "Siddu@1206", "blood_bank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $role = $_POST["userType"];
    $success = false;

    if ($role === "donor") {
        $name = $_POST["donorName"];
        $email = $_POST["donorEmail"];
        $phone = $_POST["donorPhone"];
        $dob = $_POST["donorDOB"];
        $gender = $_POST["donorGender"];
        $bloodType = $_POST["donorBloodType"];
        $weight = $_POST["donorWeight"];
        $lastDonation = $_POST["donorLastDonation"];
        $address = $_POST["donorAddress"];
        $password = $_POST["donorPassword"];

        $age = date_diff(date_create($dob), date_create('today'))->y;
        $health = "Weight: $weight kg, Gender: $gender, Address: $address";

        $stmt = $conn->prepare("INSERT INTO Donor (Name, Age, BloodType, Contact, LastDonationDate, HealthStatus) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissss", $name, $age, $bloodType, $phone, $lastDonation, $health);
        $success = $stmt->execute();
    } elseif ($role === "hospital") {
        $name = $_POST["hospitalName"];
        $email = $_POST["hospitalEmail"];
        $phone = $_POST["hospitalPhone"];
        $address = $_POST["hospitalAddress"];
        $password = $_POST["hospitalPassword"];

        $stmt = $conn->prepare("INSERT INTO Hospital (Name, Address, Contact) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $address, $phone);
        $success = $stmt->execute();
    } elseif ($role === "bloodBank") {
        $name = $_POST["bloodBankName"];
        $email = $_POST["bloodBankEmail"];
        $phone = $_POST["bloodBankPhone"];
        $location = $_POST["bloodBankAddress"];
        $password = $_POST["bloodBankPassword"];

        $stmt = $conn->prepare("INSERT INTO BloodCenter (Name, Location, Contact) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $location, $phone);
        $success = $stmt->execute();
    }

    if ($success) {
        $stmt2 = $conn->prepare("INSERT INTO MobileUser (Name, Email, PhoneNumber, PasswordHash, Role) VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param("sssss", $name, $email, $phone, $password, ucfirst($role));
        $stmt2->execute();

        echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed. Please try again.'); window.location.href='register.php';</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detailed Registration Page</title>
    <link rel="stylesheet" href="registerstyle.css">
    <script>
        function toggleFormFields() {
            const userType = document.getElementById("userType").value;
            document.getElementById("donorFields").style.display = "none";
            document.getElementById("bloodBankFields").style.display = "none";
            document.getElementById("hospitalFields").style.display = "none";

            if (userType === "donor") {
                document.getElementById("donorFields").style.display = "block";
            } else if (userType === "bloodBank") {
                document.getElementById("bloodBankFields").style.display = "block";
            } else if (userType === "hospital") {
                document.getElementById("hospitalFields").style.display = "block";
            }
        }
    </script>
</head>

<body>
    <h1>Registration Form</h1>

    <form action="register.php" method="POST">
        <label for="userType">Register As:</label>
        <select id="userType" name="userType" onchange="toggleFormFields()" required>
            <option value="">-- Select --</option>
            <option value="donor">Donor</option>
            <option value="bloodBank">Blood Bank</option>
            <option value="hospital">Hospital</option>
        </select>
        <br><br>

        <!-- Donor Fields -->
        <div id="donorFields" style="display:none;">
            <h2>Donor Details</h2>
            <label for="donorName">Full Name:</label>
            <input type="text" id="donorName" name="donorName"><br><br>

            <label for="donorEmail">Email:</label>
            <input type="email" id="donorEmail" name="donorEmail"><br><br>

            <label for="donorPhone">Phone Number:</label>
            <input type="tel" id="donorPhone" name="donorPhone"><br><br>

            <label for="donorDOB">Date of Birth:</label>
            <input type="date" id="donorDOB" name="donorDOB"><br><br>

            <label for="donorGender">Gender:</label>
            <select id="donorGender" name="donorGender">
                <option value="">-- Select --</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select><br><br>

            <label for="donorBloodType">Blood Type:</label>
            <select id="donorBloodType" name="donorBloodType">
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

            <label for="donorWeight">Weight (kg):</label>
            <input type="number" id="donorWeight" name="donorWeight" min="0"><br><br>

            <label for="donorLastDonation">Last Donation Date:</label>
            <input type="date" id="donorLastDonation" name="donorLastDonation"><br><br>

            <label for="donorPassword">Password:</label>
            <input type="password" id="donorPassword" name="donorPassword"><br><br>

            <label for="donorAddress">Address:</label>
            <textarea id="donorAddress" name="donorAddress"></textarea><br><br>
        </div>

        <!-- Blood Bank Fields -->
        <div id="bloodBankFields" style="display:none;">
            <h2>Blood Bank Details</h2>
            <label for="bloodBankName">Blood Bank Name:</label>
            <input type="text" id="bloodBankName" name="bloodBankName"><br><br>

            <label for="bloodBankEmail">Email:</label>
            <input type="email" id="bloodBankEmail" name="bloodBankEmail"><br><br>

            <label for="bloodBankPhone">Phone Number:</label>
            <input type="tel" id="bloodBankPhone" name="bloodBankPhone"><br><br>

            <label for="bloodBankPassword">Password:</label>
            <input type="password" id="bloodBankPassword" name="bloodBankPassword"><br><br>

            <label for="bloodBankAddress">Address:</label>
            <textarea id="bloodBankAddress" name="bloodBankAddress"></textarea><br><br>
        </div>

        <!-- Hospital Fields -->
        <div id="hospitalFields" style="display:none;">
            <h2>Hospital Details</h2>
            <label for="hospitalName">Hospital Name:</label>
            <input type="text" id="hospitalName" name="hospitalName"><br><br>

            <label for="hospitalEmail">Email:</label>
            <input type="email" id="hospitalEmail" name="hospitalEmail"><br><br>

            <label for="hospitalPhone">Phone Number:</label>
            <input type="tel" id="hospitalPhone" name="hospitalPhone"><br><br>

            <label for="hospitalPassword">Password:</label>
            <input type="password" id="hospitalPassword" name="hospitalPassword"><br><br>

            <label for="hospitalAddress">Address:</label>
            <textarea id="hospitalAddress" name="hospitalAddress"></textarea><br><br>
        </div>

        <button type="submit">Register</button>
    </form>
</body>
</html>
