<?php 
include 'db_connect.php';  // Your DB connection file

// Query to fetch transaction data
$sql = "
  SELECT 
    t.TransactionID,
    t.DonorID,
    t.RecipientID,
    t.BloodID,
    t.Date,
    t.Type
  FROM Transaction t
  ORDER BY t.Date DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Transactions | Blood Bank Management</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="trans-style.css" />
</head>
<body>

  <div class="container">
    <h1>Transaction Records</h1>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th>Transaction ID</th>
          <th>Donor ID</th>
          <th>Recipient ID</th>
          <th>Blood ID</th>
          <th>Date</th>
          <th>Type</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['TransactionID']); ?></td>
              <td><?php echo htmlspecialchars($row['DonorID']); ?></td>
              <td><?php echo htmlspecialchars($row['RecipientID']); ?></td>
              <td><?php echo htmlspecialchars($row['BloodID']); ?></td>
              <td><?php echo htmlspecialchars($row['Date']); ?></td>
              <td><?php echo htmlspecialchars($row['Type']); ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6" style="text-align:center;">No transactions found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <br>
    <a href="bloodbank-dashboard.php">← Back to Dashboard</a>
  </div>

</body>
</html>
