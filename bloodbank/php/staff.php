<?php
include 'db_connect.php';
session_start();

// We assume user is already logged in from bloodbank-dashboard
$staff = [];
$sql = "SELECT * FROM Staff";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $staff[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Staff Management | Blood Bank</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="addstaff.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <h1>Staff Management</h1>
  

  
  <div class="table-toolbar">
    <span class="staff-count">Total Staff: <?php echo count($staff); ?></span>
<button class="add-staff-btn" onclick="window.location.href='add-staff.php'">
  <i class="fas fa-plus"></i> Add Staff
</button>

  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Contact</th>
        <th>Shift</th>
        <th>Salary</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($staff) > 0): ?>
        <?php foreach ($staff as $s): ?>
          <tr>
            <td><?php echo $s['StaffID']; ?></td>
            <td><?php echo htmlspecialchars($s['Name']); ?></td>
            <td><?php echo $s['Role']; ?></td>
            <td><?php echo $s['Contact']; ?></td>
            <td><span class="status-indicator status-active"></span><?php echo $s['Shift']; ?></td>
            <td><?php echo $s['Salary']; ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="7">No staff members found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  
  <a href="bloodbank-dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
  
  <footer>
    <p>&copy; 2023 Blood Bank Management System. All rights reserved.</p>
  </footer>
</body>
</html>
