<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $role = $_POST["role"];
    $contact = $_POST["contact"];
    $shift = $_POST["shift"];
    $salary = $_POST["salary"];

    $stmt = $conn->prepare("INSERT INTO Staff (Name, Role, Contact, Shift, Salary) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $name, $role, $contact, $shift, $salary);

    if ($stmt->execute()) {
        echo "<script>alert('Staff member added successfully!'); window.location.href='staff.php';</script>";
    } else {
        echo "<script>alert('Error: Could not add staff member.'); window.location.href='addstaff.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add New Staff | Blood Bank</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <h1>Add New Staff</h1>

  <form action="add-staff.php" method="POST">
    <div class="input-container">
      <input type="text" id="name" name="name" required>
      <label for="name">Full Name:</label>
    </div>

    <div class="input-container">
      <select id="role" name="role" required>
        <option value="">Select Role</option>
        <option value="Admin">Admin</option>
        <option value="Technician">Technician</option>
        <option value="Nurse">Nurse</option>
      </select>
      <label for="role">Role:</label>
    </div>

    <div class="input-container">
      <input type="text" id="contact" name="contact" required>
      <label for="contact">Contact Number:</label>
    </div>

    <div class="input-container">
      <select id="shift" name="shift" required>
        <option value="">Select Shift</option>
        <option value="Morning">Morning</option>
        <option value="Evening">Evening</option>
        <option value="Night">Night</option>
      </select>
      <label for="shift">Shift:</label>
    </div>

    <div class="input-container">
      <input type="number" id="salary" name="salary" required>
      <label for="salary">Salary:</label>
    </div>

    <input type="submit" value="Add Staff">
  </form>

  <br>
  <a href="staff.php">Back to Staff List</a>

  <script>
    // Add loading state when form is submitted
    document.querySelector('form').addEventListener('submit', function() {
      this.classList.add('loading');
    });
  </script>

</body>
</html>