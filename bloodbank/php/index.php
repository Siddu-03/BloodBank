<?php include 'db_connect.php'; ?>

 <!-- Main page for the Blood Bank Management System -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blood Bank Management System</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="index-style.css">
  
</head>
<body>
  <header>
    <h1>BloodVault</h1>
  </header>


    <!-- Navigation Bar -->
    <nav>
      <ul>
          <li><a href="map.php">Map</a></li>
          <li><a href="ai.php">AI Chat</a></li>
          <li><a href="accidents.php">Accidents</a></li>
          <li><a href="campagins.php">Campaigns</a></li>
      </ul>
  </nav>
  <main>
    <div class="container">
      <h1>"Stay Updated • Be Informed • Save Lives"</h1>
      <p>Welcome to BloodVault. 
      <br>We connect donors with patients and medical facilities to ensure a steady supply of life-saving blood components.</p>
      
      <div class="blood-types">
        <div class="blood-type">A+</div>
        <div class="blood-type">A-</div>
        <div class="blood-type">B+</div>
        <div class="blood-type">B-</div>
        <div class="blood-type">AB+</div>
        <div class="blood-type">AB-</div>
        <div class="blood-type">O+</div>
        <div class="blood-type">O-</div>
      </div>
      
      
      
      <a href="login.php" class="cta-button">Login to System</a>
      
      <div class="features">
        <div class="feature">
          <h3>Donor Management</h3>
          <p>Track and manage donor information, donation history, and eligibility status.</p>
        </div>
        <div class="feature">
          <h3>Inventory Control</h3>
          <p>Monitor blood component stock levels and expiration dates efficiently.</p>
        </div>
        <div class="feature">
          <h3>Request Management</h3>
          <p>Process and fulfill blood requests from hospitals and medical facilities.</p>
        </div>
      </div>
    </div>
  </main>
  <div class="container">
  <p>Every donation counts. <br>Join our mission to save lives and make a difference in your community.</p>
  <button class="register-button" onclick="window.location.href='register.php'">
    Register Here
</button>
</div>
  <div class="background-elements">
    <div class="blood-drop" style="left: 10%; animation-delay: 2s;"></div>
    <div class="blood-drop" style="left: 30%; animation-delay: 5s;"></div>
    <div class="blood-drop" style="left: 50%; animation-delay: 0s;"></div>
    <div class="blood-drop" style="left: 70%; animation-delay: 7s;"></div>
    <div class="blood-drop" style="left: 90%; animation-delay: 3s;"></div>
  </div>

</section>
  <footer>
    <p>&copy; 2025 BloodVault. All rights reserved.</p>
  </footer>
  <script src="js/app.js"></script>
</body>
</html>