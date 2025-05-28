<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $campaign_name = $_POST["campaign_name"];
    $target_audience = $_POST["target_audience"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $description = $_POST["description"];

    $stmt = $conn->prepare("INSERT INTO AwarenessCampaign (Name, TargetAudience, StartDate, EndDate, Outcome) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $campaign_name, $target_audience, $start_date, $end_date, $description);

    if ($stmt->execute()) {
        echo "<script>alert('Campaign added successfully!'); window.location.href='campagins.php';</script>";
    } else {
        echo "<script>alert('Error: Could not save campaign.'); window.location.href='add-campaign.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add New Awareness Campaign</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Add this line -->
  <link rel="stylesheet" href="newcamp.css">
  <!-- Optional: Add Google Fonts for enhanced typography -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Add New Awareness Campaign</h1>

    <form action="new-campaign.php" method="post" id="campaignForm">
      <!-- Wrap each label-input pair in form-group divs -->
      <div class="form-group">
        <label for="campaign_name">Campaign Name:</label>
        <input type="text" id="campaign_name" name="campaign_name" required>
      </div>

      <div class="form-group">
        <label for="organizer">Organizer Name:</label>
        <input type="text" id="organizer" name="organizer" required>
      </div>

      <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
      </div>

      <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
      </div>

      <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
      </div>

      <div class="form-group">
        <label for="target_audience">Target Audience:</label>
        <input type="text" id="target_audience" name="target_audience">
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>
      </div>

      <input type="submit" value="Add Campaign">
    </form>

    <a href="campagins.php">&larr; Back to Dashboard</a>
  </div>
  <script>
// Enhanced form submission with loading state
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('campaignForm');
    const submitBtn = form.querySelector('input[type="submit"]');
    
    form.addEventListener('submit', function() {
        form.classList.add('form-loading');
        submitBtn.value = 'Processing...';
        submitBtn.disabled = true;
    });
});
</script>
</body>
</html>
