<?php 
session_start(); 
include 'db_connect.php';  

// Check if user is logged in and is a hospital
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "Hospital") {     
    header("Location: login.php");     
    exit; 
}  

$userPhone = $_SESSION["user_phone"]; 
$userName = $_SESSION["user_name"]; 
$email = $_SESSION["user_email"];  

// Fetch hospital info 
$hospitalQuery = $conn->prepare("     
    SELECT Hospital.HospitalID, Hospital.Name AS HospitalName, Hospital.Address, Hospital.Contact     
    FROM Hospital     
    JOIN MobileUser ON MobileUser.PhoneNumber = Hospital.Contact     
    WHERE MobileUser.PhoneNumber = ? 
"); 
$hospitalQuery->bind_param("s", $userPhone); 
$hospitalQuery->execute(); 
$result = $hospitalQuery->get_result();  

if ($result && $result->num_rows === 1) {     
    $hospitalData = $result->fetch_assoc(); 
} else {     
    $hospitalData = null; 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Dashboard - Blood Bank System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="h-dashboardstyle.css">
</head>
<body>
    <!-- Loading Screen -->
    <div id="loadingScreen" class="loading-screen">
        <div class="loading-content">
            <div class="loading-logo">
                <div class="blood-drop"></div>
            </div>
            <div class="loading-text">Loading Dashboard...</div>
            <div class="loading-bar">
                <div class="loading-progress"></div>
            </div>
        </div>
    </div>

    <!-- Floating Particles -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>



    <div class="container">
        <!-- Header Section -->
        <header class="header">
            <div class="welcome-section">
                <h1 class="welcome-title">Hospital Dashboard</h1>
                <p class="welcome-subtitle">Welcome, <?php echo htmlspecialchars($hospitalData['HospitalName'] ?? $userName); ?></p>
            </div>
        </header>

        <!-- Hospital Information Grid -->
        <?php if ($hospitalData): ?>
        <div class="info-grid">
            <div class="info-card">
                <div class="info-label">Hospital ID</div>
                <div class="info-value"><?php echo htmlspecialchars($hospitalData['HospitalID']); ?></div>
            </div>
            
            <div class="info-card">
                <div class="info-label">Hospital Name</div>
                <div class="info-value"><?php echo htmlspecialchars($hospitalData['HospitalName']); ?></div>
            </div>
            
            <div class="info-card">
                <div class="info-label">Address</div>
                <div class="info-value"><?php echo htmlspecialchars($hospitalData['Address']); ?></div>
            </div>
            
            <div class="info-card">
                <div class="info-label">Contact</div>
                <div class="info-value"><?php echo htmlspecialchars($hospitalData['Contact']); ?></div>
            </div>
            
            <div class="info-card">
                <div class="info-label">Email</div>
                <div class="info-value"><?php echo htmlspecialchars($email); ?></div>
            </div>
        </div>
        <?php else: ?>
        <div class="info-grid">
            <div class="info-card error-card">
                <div class="info-label">Error</div>
                <div class="info-value">No hospital record found for this user.</div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Navigation Section -->
        <section class="nav-section">
            <h2 class="nav-title">Quick Actions</h2>
            <div class="nav-buttons">
                <a href="new-request.php" class="nav-btn">
                    <span>Request Blood</span>
                </a>
                <a href="pending-requests.php" class="nav-btn">
                    <span>View Pending Requests</span>
                </a>
            </div>
        </section>
    <!-- Logout Button -->
    <a href="login.php" class="logout-btn">
        <span>Logout</span>
    </a>
        <!-- Footer -->
        <footer class="footer">
            <p>Blood Bank Management System - All Rights Reserved</p>
        </footer>
    </div>

    <script>
        // Loading Screen Animation
        window.addEventListener('load', function() {
            const loadingScreen = document.getElementById('loadingScreen');
            const progress = document.querySelector('.loading-progress');
            
            // Animate progress bar
            setTimeout(() => {
                progress.style.width = '100%';
            }, 500);
            
            // Hide loading screen
            setTimeout(() => {
                loadingScreen.style.opacity = '0';
                loadingScreen.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 500);
            }, 2000);
        });

        // Ripple effect for buttons
        function createRipple(event) {
            const button = event.currentTarget;
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            button.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 800);
        }

        // Add ripple effect to buttons
        document.querySelectorAll('.nav-btn, .logout-btn').forEach(button => {
            button.addEventListener('click', createRipple);
        });

        // Parallax effect for cards
        document.addEventListener('mousemove', function(e) {
            const cards = document.querySelectorAll('.info-card, .nav-btn');
            const x = (e.clientX / window.innerWidth) * 100;
            const y = (e.clientY / window.innerHeight) * 100;
            
            cards.forEach(card => {
                const speed = 0.05;
                const xOffset = (x - 50) * speed;
                const yOffset = (y - 50) * speed;
                
                card.style.transform = `translate(${xOffset}px, ${yOffset}px) rotateY(${xOffset * 0.1}deg) rotateX(${-yOffset * 0.1}deg)`;
            });
        });

        // Enhanced scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) scale(1)';
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('.info-card, .nav-btn').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>