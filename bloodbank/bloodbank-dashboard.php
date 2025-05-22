<?php include 'db_connect.php'; ?>

<!-- Blood Bank Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Dashboard</title>
    <link rel="stylesheet" href="bb-dashboardstyle.css">
</head>

<body>
    <header>
        <h1>Blood Bank Dashboard</h1>
    </header>
    <div class="container">
        <button id="logoutBtn" style="float: right; margin: 10px;">Logout</button>

        <h2>Welcome, <span id="bankName">Bruce Wayne</span></h2>
<section><button class="blood-inventory-btn" onclick="window.location.href='blood-inventory.php'">View Blood Stock</button></section>
        <section><button class="penreq" onclick="window.location.href='pending-requests.php'">Pending Requests</button></section>
        <section><button class="staff" onclick="window.location.href='staff.php'">Staff</button></section>
        <section><button class="staff" onclick="window.location.href='transactions.php'">Transactions</button></section>
    </section>
    </div>
    <footer>
        <p>Blood Bank Management System - All Rights Reserved</p>
    </footer>
    <script src="js/app.js"></script>
</body>
</html>
