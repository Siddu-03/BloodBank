<?php 
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "Siddu@1206", "blood_bank");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Get the user's phone number and role from MobileUser
$userQuery = $conn->prepare("SELECT PhoneNumber, Email, Name FROM MobileUser WHERE UserID = ? AND Role = 'Donor'");
$userQuery->bind_param("i", $userId);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult->num_rows === 1) {
    $user = $userResult->fetch_assoc();
    $phone = $user['PhoneNumber'];
    $email = $user['Email'];
    $name = $user['Name'];
    
    // Now fetch the donor details from Donor table using the phone number
    $donorQuery = $conn->prepare("SELECT * FROM Donor WHERE Contact = ?");
    $donorQuery->bind_param("s", $phone);
    $donorQuery->execute();
    $donorResult = $donorQuery->get_result();
    
    if ($donorResult->num_rows === 1) {
        $donorData = $donorResult->fetch_assoc();
    } else {
        $donorData = null;
    }
} else {
    $donorData = null;
}

// Function to format date
function formatDate($date) {
    if ($date && $date !== '0000-00-00') {
        return date('F j, Y', strtotime($date));
    }
    return 'Not available';
}

// Function to get status indicator
function getStatusIndicator($status) {
    if (strtolower($status) === 'eligible' || strtolower($status) === 'healthy') {
        return '<span class="status-indicator status-active"></span>';
    } else {
        return '<span class="status-indicator status-inactive"></span>';
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard - Blood Bank Management</title>
    <link rel="stylesheet" href="d-dashboardstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <meta name="description" content="Blood Bank Donor Dashboard - View your donation history and profile">
    <meta name="theme-color" content="#dc2626">
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loading-content">
            <div class="loading-logo" role="img" aria-label="Blood Bank Logo"></div>
            <div class="loading-text">Loading Donor Dashboard</div>
            <div class="loading-subtext">Preparing your profile...</div>
            <div class="loading-bar" role="progressbar" aria-label="Loading progress">
                <div class="loading-progress"></div>
            </div>
        </div>
    </div>

    <!-- Floating Particles -->
    <div class="particles" aria-hidden="true">
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

    <!-- Main Container -->
    <div class="container">
        <!-- Logout Button -->
        <button onclick="handleLogout()" aria-label="Logout from dashboard">
            <span class="sr-only">Logout</span>
            Logout
        </button>

        <?php if ($donorData): ?>
            <h2>Welcome <?php echo htmlspecialchars($name); ?></h2>
            
            <div class="donor-info">
                <p class="info-card" data-category="identification">
                    <strong>Donor ID:</strong> 
                    <span class="donor-id">#<?php echo str_pad($donorData["DonorID"], 6, "0", STR_PAD_LEFT); ?></span>
                </p>
                
                <p class="info-card blood-type-card" data-category="medical">
                    <strong>Blood Type:</strong> 
                    <span class="blood-type"><?php echo htmlspecialchars($donorData["BloodType"]); ?></span>
                </p>
                
                <p class="info-card" data-category="personal">
                    <strong>Age:</strong> 
                    <span class="age"><?php echo htmlspecialchars($donorData["Age"]); ?> years old</span>
                </p>
                
                <p class="info-card" data-category="contact">
                    <strong>Contact:</strong> 
                    <span class="contact"><?php echo htmlspecialchars($donorData["Contact"]); ?></span>
                </p>
                
                <p class="info-card" data-category="contact">
                    <strong>Email:</strong> 
                    <span class="email"><?php echo htmlspecialchars($email); ?></span>
                </p>
                
                <p class="info-card health-status-card" data-category="medical">
                    <strong>Health Status:</strong> 
                    <?php echo getStatusIndicator($donorData["HealthStatus"]); ?>
                    <span class="health-status"><?php echo htmlspecialchars($donorData["HealthStatus"]); ?></span>
                </p>
                
                <p class="info-card donation-date-card" data-category="history">
                    <strong>Last Donation:</strong> 
                    <span class="donation-date"><?php echo formatDate($donorData["LastDonationDate"]); ?></span>
                </p>
            </div>
            
        <?php else: ?>
            <h2>Welcome to Blood Bank</h2>
            <div class="donor-info">
                <p class="info-card no-record">
                    <strong>No Donor Record Found</strong><br>
                    It appears you don't have a donor profile yet. Please contact the blood bank administration to set up your donor profile.
                </p>
            </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript -->
    <script>
        // Loading screen management - Show immediately and hide after delay
        window.addEventListener('load', function() {
            // Ensure loading screen is visible first
            const loadingScreen = document.getElementById('loadingScreen');
            loadingScreen.style.display = 'flex';
            loadingScreen.style.opacity = '1';
            loadingScreen.style.visibility = 'visible';
            
            // Hide loading screen after 3 seconds
            setTimeout(function() {
                loadingScreen.classList.add('hidden');
                
                // Remove loading screen from DOM after animation completes
                setTimeout(function() {
                    if (loadingScreen.parentNode) {
                        loadingScreen.remove();
                    }
                }, 1000);
            }, 3000); // Show loading for 3 seconds
        });

        // Logout function with confirmation
        function handleLogout() {
            if (confirm('Are you sure you want to logout?')) {
                // Add fade out effect before redirect
                document.body.style.opacity = '0';
                document.body.style.transition = 'opacity 0.5s ease';
                
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 500);
            }
        }

        // Ripple effect for cards
        function createRipple(event) {
            const card = event.currentTarget;
            const ripple = document.createElement('span');
            const rect = card.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            ripple.classList.add('ripple');
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            card.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 800);
        }

        // Add ripple effect to all cards
        window.addEventListener('load', function() {
            setTimeout(function() {
                const cards = document.querySelectorAll('.info-card');
                cards.forEach(card => {
                    card.addEventListener('click', createRipple);
                });
            }, 4000);
        });

        // Accessibility: Announce content loading
        setTimeout(function() {
            const announcement = document.createElement('div');
            announcement.setAttribute('aria-live', 'polite');
            announcement.setAttribute('aria-atomic', 'true');
            announcement.className = 'sr-only';
            announcement.textContent = 'Donor dashboard loaded successfully';
            document.body.appendChild(announcement);
        }, 4000);

        // Performance: Intersection Observer for animations
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);

            window.addEventListener('load', function() {
                setTimeout(function() {
                    const cards = document.querySelectorAll('.info-card');
                    cards.forEach(card => {
                        card.style.animationPlayState = 'paused';
                        observer.observe(card);
                    });
                }, 4000);
            });
        }

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                // Close any open modals or focus traps
                document.activeElement.blur();
            }
        });

        // Copy to clipboard functionality for donor ID
        window.addEventListener('load', function() {
            setTimeout(function() {
                const donorIdElement = document.querySelector('.donor-id');
                if (donorIdElement) {
                    donorIdElement.style.cursor = 'pointer';
                    donorIdElement.title = 'Click to copy Donor ID';
                    
                    donorIdElement.addEventListener('click', function() {
                        navigator.clipboard.writeText(this.textContent).then(function() {
                            // Show temporary success message
                            const originalText = donorIdElement.textContent;
                            donorIdElement.textContent = 'Copied!';
                            donorIdElement.style.color = '#10b981';
                            
                            setTimeout(function() {
                                donorIdElement.textContent = originalText;
                                donorIdElement.style.color = '';
                            }, 1500);
                        }).catch(function() {
                            console.log('Failed to copy donor ID');
                        });
                    });
                }
            }, 4000);
        });

        // Auto-refresh dashboard every 5 minutes to keep data current
        setInterval(function() {
            // Only refresh if the page is visible
            if (!document.hidden) {
                location.reload();
            }
        }, 300000); // 5 minutes

        // Handle page visibility changes
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Page is hidden, pause animations
                document.body.style.animationPlayState = 'paused';
            } else {
                // Page is visible, resume animations
                document.body.style.animationPlayState = 'running';
            }
        });
    </script>
</body>
</html>