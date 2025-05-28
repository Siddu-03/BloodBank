<?php
include 'db_connect.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user_email'];

// Fetch Blood Center info from MobileUser and BloodCenter
$query = $conn->prepare("
    SELECT bc.BloodCenterID, bc.Name, bc.Location, bc.Contact, mu.Email 
    FROM BloodCenter bc 
    JOIN MobileUser mu ON bc.Contact = mu.PhoneNumber 
    WHERE mu.Email = ? AND mu.Role = 'Admin'
");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result && $result->num_rows > 0) {
    $bloodCenter = $result->fetch_assoc();
} else {
    echo "<script>alert('No blood bank data found for this user.'); window.location.href='login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Dashboard - <?php echo htmlspecialchars($bloodCenter['Name']); ?></title>
    
    <!-- Performance & SEO Meta Tags -->
    <meta name="description" content="Advanced Blood Bank Management Dashboard">
    <meta name="theme-color" content="#dc2626">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <!-- Preload Critical Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts - Inter with Multiple Weights -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Advanced CSS -->
    <link rel="stylesheet" href="bb-dashboardstyle.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%23dc2626'/><path d='M30 35h40v10H30zM45 20h10v40H45z' fill='white'/></svg>">
</head>
<body>

    <!-- Floating Particles Background -->
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

    <!-- Advanced Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="loading-container">
            <div class="loading-logo">
                <svg width="80" height="80" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100" height="100" fill="#dc2626" rx="15" class="logo-bg"/>
                    <path d="M30 35h40v10H30zM45 20h10v40H45z" fill="white" class="logo-cross"/>
                </svg>
            </div>
            <div class="loading-text">Blood Bank Dashboard</div>
            <div class="loading-bar">
                <div class="loading-progress"></div>
            </div>
        </div>
    </div>



    <!-- Header Section -->
    <header class="header">
        <div class="container">
            <div class="welcome-section">
                <h1 class="welcome-title">Welcome Back</h1>
                <p class="welcome-subtitle"><?php echo htmlspecialchars($bloodCenter['Name']); ?></p>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        
        <!-- Blood Center Information Cards -->
        <section class="info-grid" role="region" aria-label="Blood Center Information">
            <div class="info-card" tabindex="0">
                <div class="info-label">
                    <span class="sr-only">Blood Center</span>
                    ID Number
                </div>
                <div class="info-value" id="center-id"><?php echo htmlspecialchars($bloodCenter['BloodCenterID']); ?></div>
            </div>
            
            <div class="info-card" tabindex="0">
                <div class="info-label">
                    <span class="sr-only">Contact</span>
                    Email Address
                </div>
                <div class="info-value" id="center-email"><?php echo htmlspecialchars($bloodCenter['Email']); ?></div>
            </div>
            
            <div class="info-card" tabindex="0">
                <div class="info-label">
                    <span class="sr-only">Center</span>
                    Location
                </div>
                <div class="info-value" id="center-location"><?php echo htmlspecialchars($bloodCenter['Location']); ?></div>
            </div>
            
            <div class="info-card" tabindex="0">
                <div class="info-label">
                    <span class="sr-only">Phone</span>
                    Contact Number
                </div>
                <div class="info-value" id="center-contact"><?php echo htmlspecialchars($bloodCenter['Contact']); ?></div>
            </div>
        </section>

        <!-- Navigation Section -->
        <section class="nav-section" role="navigation" aria-label="Dashboard Navigation">
            <h3 class="nav-title">Dashboard Navigation</h3>
            <div class="nav-buttons">
                <!-- Uncomment when staff.php is ready -->
                <!-- <button class="nav-btn" onclick="navigateTo('staff.php')" aria-describedby="staff-desc">
                    <span>Staff Management</span>
                    <span id="staff-desc" class="sr-only">Manage blood bank staff members</span>
                </button> -->
                
                <button class="nav-btn" onclick="navigateTo('pending-requests.php')" aria-describedby="requests-desc">
                    <span>Pending Requests</span>
                    <span id="requests-desc" class="sr-only">View and manage pending blood requests</span>
                </button>
                
                <button class="nav-btn" onclick="navigateTo('transactions.php')" aria-describedby="transactions-desc">
                    <span>Transaction History</span>
                    <span id="transactions-desc" class="sr-only">View blood bank transaction history</span>
                </button>
            </div>
        </section>
            <!-- Logout Button -->
    <button class="logout-btn" onclick="handleLogout()">
        <span>Logout</span>
    </button>

        <!-- Quick Stats Section (Optional - Ready for future use) -->
        <!--
        <section class="stats-section" role="region" aria-label="Quick Statistics">
            <h3 class="stats-title">Quick Overview</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-number" data-count="24">0</div>
                    <div class="stat-label">Pending Requests</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🩸</div>
                    <div class="stat-number" data-count="156">0</div>
                    <div class="stat-label">Total Donations</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-number" data-count="89">0</div>
                    <div class="stat-label">Success Rate %</div>
                </div>
            </div>
        </section>
        -->

    </main>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="toast-container" aria-live="polite"></div>

    <!-- Advanced JavaScript -->
    <script>
        // Global variables
        let isLoading = false;
        let animationQueue = [];

        // DOM Content Loaded Event
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
        });

        // Initialize Dashboard
        function initializeDashboard() {
            // Show loading screen
            showLoadingScreen();
            
            // Simulate loading time and initialize components
            setTimeout(() => {
                hideLoadingScreen();
                initializeAnimations();
                initializeInteractions();
                initializeAccessibility();
            }, 2000);
        }

        // Loading Screen Functions
        function showLoadingScreen() {
            const loadingScreen = document.getElementById('loading-screen');
            const progressBar = loadingScreen.querySelector('.loading-progress');
            
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                }
                progressBar.style.width = progress + '%';
            }, 200);
        }

        function hideLoadingScreen() {
            const loadingScreen = document.getElementById('loading-screen');
            loadingScreen.style.opacity = '0';
            loadingScreen.style.pointerEvents = 'none';
            
            setTimeout(() => {
                loadingScreen.style.display = 'none';
                document.body.classList.add('loaded');
            }, 500);
        }

        // Advanced Animations
        function initializeAnimations() {
            // Intersection Observer for scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, observerOptions);

            // Observe all cards
            document.querySelectorAll('.info-card, .nav-btn').forEach(card => {
                observer.observe(card);
            });

            // Counter animation for stats (if enabled)
            animateCounters();
        }

        // Counter Animation
        function animateCounters() {
            const counters = document.querySelectorAll('[data-count]');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.textContent = Math.floor(current);
                }, 16);
            });
        }

        // Interactive Features
        function initializeInteractions() {
            // Advanced ripple effect
            const buttons = document.querySelectorAll('.nav-btn, .logout-btn, .info-card');
            buttons.forEach(button => {
                button.addEventListener('click', createRipple);
                button.addEventListener('mouseenter', addHoverEffect);
                button.addEventListener('mouseleave', removeHoverEffect);
            });

            // Copy to clipboard functionality
            const infoValues = document.querySelectorAll('.info-value');
            infoValues.forEach(value => {
                value.addEventListener('click', function() {
                    copyToClipboard(this.textContent);
                    showToast('Copied to clipboard!', 'success');
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', handleKeyboardShortcuts);
        }

        // Ripple Effect
        function createRipple(e) {
            const button = e.currentTarget;
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            button.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 800);
        }

        // Hover Effects
        function addHoverEffect(e) {
            const element = e.currentTarget;
            element.style.transform += ' scale(1.02)';
        }

        function removeHoverEffect(e) {
            const element = e.currentTarget;
            element.style.transform = element.style.transform.replace(' scale(1.02)', '');
        }

        // Navigation Functions
        function navigateTo(url) {
            if (isLoading) return;
            
            isLoading = true;
            showToast('Loading...', 'info');
            
            // Add loading animation
            document.body.style.opacity = '0.7';
            
            setTimeout(() => {
                window.location.href = url;
            }, 500);
        }

        function handleLogout() {
            if (confirm('Are you sure you want to logout?')) {
                showToast('Logging out...', 'info');
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 1000);
            }
        }

        // Utility Functions
        function copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text);
            } else {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
            }
        }

        // Toast Notifications
        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <span class="toast-message">${message}</span>
                    <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
                </div>
            `;

            container.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }

        // Keyboard Shortcuts
        function handleKeyboardShortcuts(e) {
            // Escape key - focus logout
            if (e.key === 'Escape') {
                document.querySelector('.logout-btn').focus();
            }
            
            // Alt + P - Pending requests
            if (e.altKey && e.key === 'p') {
                e.preventDefault();
                navigateTo('pending-requests.php');
            }
            
            // Alt + T - Transactions
            if (e.altKey && e.key === 't') {
                e.preventDefault();
                navigateTo('transactions.php');
            }
        }

        // Accessibility Features
        function initializeAccessibility() {
            // High contrast mode detection
            if (window.matchMedia && window.matchMedia('(prefers-contrast: high)').matches) {
                document.body.classList.add('high-contrast');
            }

            // Reduced motion detection
            if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                document.body.classList.add('reduced-motion');
            }

            // Focus management
            const focusableElements = document.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );

            focusableElements.forEach(element => {
                element.addEventListener('focus', function() {
                    this.classList.add('focused');
                });

                element.addEventListener('blur', function() {
                    this.classList.remove('focused');
                });
            });
        }

        // Performance Monitoring
        if ('performance' in window) {
            window.addEventListener('load', function() {
                const perfData = performance.getEntriesByType('navigation')[0];
                console.log('Page Load Time:', perfData.loadEventEnd - perfData.fetchStart, 'ms');
            });
        }

        // Service Worker Registration (Optional)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed');
                    });
            });
        }
    </script>

    <!-- Additional CSS for JavaScript Components -->
    <style>
        /* Loading Screen */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0a0e27 0%, #1a1b3e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            transition: opacity 0.5s ease;
        }

        .loading-container {
            text-align: center;
            color: white;
        }

        .loading-logo {
            margin-bottom: 2rem;
            animation: logoFloat 2s ease-in-out infinite;
        }

        .logo-bg {
            animation: logoPulse 2s ease-in-out infinite;
        }

        .logo-cross {
            animation: crossRotate 3s linear infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes logoPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        @keyframes crossRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            animation: textGlow 2s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            0% { text-shadow: 0 0 5px rgba(220, 38, 38, 0.5); }
            100% { text-shadow: 0 0 20px rgba(220, 38, 38, 0.8); }
        }

        .loading-bar {
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            overflow: hidden;
            margin: 0 auto;
        }

        .loading-progress {
            height: 100%;
            background: var(--gradient-primary);
            border-radius: 2px;
            transition: width 0.3s ease;
            animation: progressGlow 1.5s ease-in-out infinite alternate;
        }

        @keyframes progressGlow {
            0% { box-shadow: 0 0 5px rgba(220, 38, 38, 0.5); }
            100% { box-shadow: 0 0 15px rgba(220, 38, 38, 0.8); }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            pointer-events: none;
        }

        .toast {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            box-shadow: var(--shadow-large);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: toastSlideIn 0.3s ease;
            pointer-events: auto;
            min-width: 250px;
        }

        .toast-success {
            border-left: 4px solid var(--success);
        }

        .toast-info {
            border-left: 4px solid var(--accent-blue);
        }

        .toast-warning {
            border-left: 4px solid var(--warning);
        }

        .toast-error {
            border-left: 4px solid var(--error);
        }

        @keyframes toastSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .toast-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.2s ease;
        }

        .toast-close:hover {
            opacity: 1;
        }

        /* Accessibility Enhancements */
        .focused {
            outline: 3px solid var(--accent-gold) !important;
            outline-offset: 3px !important;
        }

        .high-contrast .info-card {
            border-width: 3px;
            border-color: var(--primary-red);
        }

        .reduced-motion * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }

        /* Mobile Optimizations */
        @media (max-width: 768px) {
            .toast-container {
                left: 1rem;
                right: 1rem;
                transform: none;
            }

            .toast {
                min-width: auto;
            }
        }
    </style>

</body>
</html>