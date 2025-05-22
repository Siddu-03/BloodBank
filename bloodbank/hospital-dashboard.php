<?php include 'db_connect.php'; ?>

<!-- Hospital Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Dashboard</title>
    <link rel="stylesheet" href="h-dashboardstyle.css">
</head>

<body>
    <header>
        <h1>Hospital Dashboard</h1>
    </header>

    <div class="container">
        <button id="logoutBtn" style="float: right; margin: 10px;" a href="login.php">Logout</button>

        <h2>Welcome, <span id="hospitalName">Dr.Strange</span></h2>

        <section>
            <h3>Request Blood</h3>
            <p><a href="new-request.php">Create New Blood Request</a></p>
        </section>

        <section>
            <h3>Pending Requests</h3>
            <p><a href="pending-requests.php">View Pending Request</a></p>
        </section>

        
                    <!-- More rows dynamically -->
                </tbody>
            </table>
        </section>
    </div>

    <footer>
        <p>Blood Bank Management System - All Rights Reserved</p>
    </footer>

    <script src="js/app.js"></script>

</body>
</html>
