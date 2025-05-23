<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Transactions | Blood Bank Management</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="trans-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <div class="container">
    <h1>Transaction Records</h1>
    
    <!-- Stats Overview -->
    <div class="stats-container fade-in">
      <div class="stat-card">
        <div class="stat-value">24</div>
        <div class="stat-label">Total Transactions</div>
      </div>
      <div class="stat-card">
        <div class="stat-value">15</div>
        <div class="stat-label">Donations</div>
      </div>
      <div class="stat-card">
        <div class="stat-value">8</div>
        <div class="stat-label">Requests</div>
      </div>
      <div class="stat-card">
        <div class="stat-value">1</div>
        <div class="stat-label">Transfers</div>
      </div>
    </div>
    
    <!-- Controls -->
    <div class="controls-container">
      <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Search transactions...">
      </div>
      
      <div class="filter-group">
        <button class="filter-btn active">All</button>
        <button class="filter-btn">Donations</button>
        <button class="filter-btn">Requests</button>
        <button class="filter-btn">Transfers</button>
      </div>
      
      <div class="date-range">
        <input type="date" class="date-input" placeholder="From">
        <span>to</span>
        <input type="date" class="date-input" placeholder="To">
      </div>
    </div>
    
    <!-- Table -->
    <table class="fade-in">
      <thead>
        <tr>
          <th>ID</th>
          <th>Donor ID</th>
          <th>Recipient ID</th>
          <th>Blood ID</th>
          <th>Date</th>
          <th>Type</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>1</td>
          <td>1</td>
          <td>1</td>
          <td>2025-04-22</td>
          <td>Donation</td>
          <td>
            <button class="action-btn"><i class="fas fa-eye"></i> View</button>
            <button class="action-btn"><i class="fas fa-print"></i> Print</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>-</td>
          <td>2</td>
          <td>3</td>
          <td>2025-04-21</td>
          <td>Request</td>
          <td>
            <button class="action-btn"><i class="fas fa-eye"></i> View</button>
            <button class="action-btn"><i class="fas fa-print"></i> Print</button>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td>3</td>
          <td>-</td>
          <td>7</td>
          <td>2025-04-20</td>
          <td>Donation</td>
          <td>
            <button class="action-btn"><i class="fas fa-eye"></i> View</button>
            <button class="action-btn"><i class="fas fa-print"></i> Print</button>
          </td>
        </tr>
        <tr>
          <td>4</td>
          <td>4</td>
          <td>5</td>
          <td>2</td>
          <td>2025-04-19</td>
          <td>Transfer</td>
          <td>
            <button class="action-btn"><i class="fas fa-eye"></i> View</button>
            <button class="action-btn"><i class="fas fa-print"></i> Print</button>
          </td>
        </tr>
      </tbody>
    </table>
    
    <!-- Pagination -->
    <ul class="pagination">
      <li><a href="#">&laquo;</a></li>
      <li><a href="#" class="active">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">&raquo;</a></li>
    </ul>
    
    <a href="bloodbank-dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
  </div>
  
  <script>
    // Simple script to handle filter button active state
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
      });
    });
  </script>
</body>
</html>