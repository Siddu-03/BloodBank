<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Staff Management | Blood Bank</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="staff-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <h1>Staff Management</h1>
  
  <div class="search-container">
    <input type="text" class="search-input" placeholder="Search staff...">
    <i class="fas fa-search search-icon"></i>
  </div>
  
  <div class="filters">
    <button class="filter-btn active">All Staff</button>
    <button class="filter-btn">Doctors</button>
    <button class="filter-btn">Nurses</button>
    <button class="filter-btn">Technicians</button>
    <button class="filter-btn">Admin</button>
  </div>
  
  <div class="table-toolbar">
    <span class="staff-count">Total Staff: 1</span>
    <button class="add-staff-btn">
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
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Emma Johnson</td>
        <td>Nurse</td>
        <td>123-123-1234</td>
        <td><span class="status-indicator status-active"></span>Night</td>
        <td>35000</td>
        <td class="action-cell">
          <button class="action-btn"><i class="fas fa-edit"></i> Edit</button>
          <button class="action-btn"><i class="fas fa-trash"></i> Delete</button>
        </td>
      </tr>
      <!-- You can add more staff entries here -->
    </tbody>
  </table>
  
  <a href="bloodbank-dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
  
  <footer>
    <p>&copy; 2023 Blood Bank Management System. All rights reserved.</p>
  </footer>
</body>
</html>