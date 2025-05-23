<?php include 'db_connect.php'; ?>

<!-- Donor Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodVault - Donor Dashboard</title>
    <link rel="stylesheet" href="d-dashboardstyle.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Decorative blood drops -->
    <div class="blood-drop drop-1"></div>
    <div class="blood-drop drop-2"></div>
    <div class="blood-drop drop-3"></div>
    
    <header>
        <h1>Donor Dashboard</h1>
        <button id="logoutBtn">Logout</button>
    </header>

    <div class="container">
        <h2>Welcome, <span id="donorName">John Doe</span></h2>
        
        <!-- Stats overview -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-value">3</div>
                <div class="stat-label">Total Donations</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">3</div>
                <div class="stat-label">Lives Saved</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">A+</div>
                <div class="stat-label">Blood Type</div>
            </div>
        </div>

        <section>
            <h3>Your Profile</h3>
            <p><strong>Blood Type:</strong> <span id="bloodType">A+</span></p>
            <p><strong>Age:</strong> 28 years</p>
            <p><strong>Weight:</strong> 75 kg</p>
            <p><strong>Last Health Check:</strong> 2025-03-15 (Passed)</p>
        </section>
        
      

        <section>
            <h3>Your Donation History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Blood Bank</th>
                        <th>Blood Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="donationHistory">
                    <tr>
                        <td>2025-04-01</td>
                        <td>City Blood Bank</td>
                        <td>A+</td>
                        <td>1 unit</td>
                        <td>Processed</td>
                    </tr>
                    <tr>
                        <td>2024-11-15</td>
                        <td>Memorial Hospital</td>
                        <td>A+</td>
                        <td>1 unit</td>
                        <td>Used</td>
                    </tr>
                    <tr>
                        <td>2024-07-22</td>
                        <td>Red Cross Center</td>
                        <td>A+</td>
                        <td>1 unit</td>
                        <td>Used</td>
                    </tr>
                </tbody>
            </table>
        </section>
        
        <!-- Achievements section -->
        <section class="badges-section">
            <h3>Your Achievements</h3>
            <div class="badges-container">
                <div class="badge" data-tooltip="First Donation">❤️</div>
                <div class="badge" data-tooltip="Regular Donor">🔄</div>
                <div class="badge" data-tooltip="Life Saver">🏅</div>
            </div>
        </section>
        
        <!-- Upcoming blood drives -->
        <section class="announcements">
            <h3>Announcements & Upcoming Drives</h3>
            <div class="announcement-item">
                <div class="announcement-date">April 30, 2025</div>
                <div class="announcement-title">Blood Drive at Central Park</div>
                <div class="announcement-content">Join us for a community blood drive at Central Park. Refreshments will be provided for all donors.</div>
            </div>
            <div class="announcement-item">
                <div class="announcement-date">May 15, 2025</div>
                <div class="announcement-title">Emergency Blood Drive</div>
                <div class="announcement-content">Type A and O donors urgently needed at City Hospital due to recent shortages.</div>
            </div>
        </section>
        
        <!-- Register call to action -->
        <div class="register-prompt">
            <p>Ready to save more lives? Schedule your next donation today!</p>
            <a href="schedule-donation.html">Schedule Now</a>
        </div>
    </div>

    <footer>
        <p>© 2025 BloodVault - All Rights Reserved</p>
    </footer>

    <script src="js/donor-dashboard.js"></script>
    <script>
        // Initialize progress bar animation once page loads
document.addEventListener('DOMContentLoaded', function() {
    // Animation for progress bar
    setTimeout(() => {
        const progressBar = document.getElementById('donationProgress');
        progressBar.style.width = '75%';
    }, 300);
});
// Add this to your donor-dashboard.js file
document.getElementById('logoutBtn').addEventListener('click', function() {
// You might want to clear any user session data here
// For example: localStorage.removeItem('user');

// Redirect to login page
window.location.href = 'login.php';
});
    </script>
    <script src="js/app.js"></script>
</body>
</html>