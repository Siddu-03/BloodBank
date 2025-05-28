<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Awareness Campaigns</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="camp-style.css">
</head>
<body>
<div class="page-container">
  <header class="header-section">
    <h1 class="page-title">Awareness Campaigns</h1>
    <a href="new-campaign.php" class="btn btn-primary add-campaign-btn">
      <span>Add New Campaign</span>
    </a>
  </header>

  <section class="announcements">
    <h3>Announcements & Upcoming Drives</h3>
    
    <?php
      // Your existing PHP code stays exactly the same
      $today = date('Y-m-d');
      $query = "SELECT * FROM AwarenessCampaign WHERE EndDate >= ? ORDER BY StartDate ASC";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $today);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<div class='announcement-item'>";
          echo "<div class='announcement-date'>" . htmlspecialchars($row['StartDate']) . " to " . htmlspecialchars($row['EndDate']) . "</div>";
          echo "<div class='announcement-title'>" . htmlspecialchars($row['Name']) . "</div>";
          echo "<div class='announcement-content'>" . htmlspecialchars($row['Outcome']) . "</div>";
          echo "</div>";
        }
      } else {
        echo "<p>No upcoming campaigns at the moment.</p>";
      }

      $stmt->close();
      $conn->close();
    ?>
  </section>

  <nav class="navigation">
    <a href="index.php" class="back-link">Back to Home</a>
  </nav>
</div>

<script src="js/app.js"></script>
</body>
</html>
