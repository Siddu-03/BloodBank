<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "Siddu@1206", "blood_bank");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $severity = $_POST['severity'];
    $casualties = $_POST['casualties'];
    $reportedBy = $_POST['reportedBy'];

    $stmt = $conn->prepare("INSERT INTO AccidentReport (Location, Latitude, Longitude, Severity, CasualtyCount, ReportedBy) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sddsis", $location, $latitude, $longitude, $severity, $casualties, $reportedBy);

    if ($stmt->execute()) {
        echo "<script>alert('Accident reported successfully!'); window.location.href='accidents.php';</script>";
    } else {
        echo "<script>alert('Failed to report accident.'); window.location.href='accidents.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Accident</title>
    <link rel="stylesheet" href="accidents-style.css"> <!-- Keep your original CSS file -->
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('accident-form');
    const submitBtn = document.querySelector('.submit-btn');
    const inputs = form.querySelectorAll('input, select');
    
    // Add floating label classes
    document.querySelectorAll('.form-group').forEach(group => {
        group.classList.add('floating-label');
    });
    
    // Real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.validity.valid && this.value.trim() !== '') {
                this.classList.remove('error');
                this.classList.add('success');
            } else if (!this.validity.valid) {
                this.classList.remove('success');
                this.classList.add('error');
            }
        });
        
        input.addEventListener('input', function() {
            this.classList.remove('error', 'success');
        });
    });
    
    // Submit button loading state
    form.addEventListener('submit', function(e) {
        submitBtn.classList.add('loading');
        submitBtn.textContent = 'Submitting...';
    });
});
</script>
</head>
<body>
<div class="accident-form-container">
    <!-- Add this back button -->
    <a href="index.php" class="back-btn" title="Back to Home">
        ←
    </a>
    <div class="accident-form-container">
        <h1>Report an Accident</h1>

        <form method="POST" action="accidents.php" id="accident-form">
            <div class="form-group">
    <div class="form-group">
    <label for="location">Accident Location:</label>
    <input type="text" id="location" name="location" placeholder="Enter full address of accident location..." required>
    <button type="button" onclick="getCoordinatesFromAddress()" class="location-btn" id="locationBtn">
        🔍 Get Coordinates
    </button>
</div>

<div class="form-group">
    <div class="coordinates-container">
        <div>
            <label for="latitude">Latitude:</label>
            <input type="number" step="any" id="latitude" name="latitude" placeholder="Auto-filled from address" readonly required>
        </div>
        <div>
            <label for="longitude">Longitude:</label>
            <input type="number" step="any" id="longitude" name="longitude" placeholder="Auto-filled from address" readonly required>
        </div>
    </div>
</div>

            <div class="form-group">
                <label for="severity">Severity:</label>
                <select id="severity" name="severity" required>
                    <option value="">--Select Severity--</option>
                    <option value="Low">Low</option>
                    <option value="Moderate">Moderate</option>
                    <option value="Severe">Severe</option>
                </select>
            </div>

            <div class="form-group">
    <label for="casualties">Number of Casualties:</label>
    <input type="number" id="casualties" name="casualties" placeholder="Enter number of casualties" required>
</div>

            <div class="form-group">
    <label for="reportedBy">Reported By:</label>
    <input type="text" id="reportedBy" name="reportedBy" placeholder="Your name or organization" required>
</div>

            <button type="submit" class="submit-btn">Submit Report</button>
        </form>
<script>
// Function to get coordinates from address using a geocoding service
async function getCoordinatesFromAddress() {
    const locationInput = document.getElementById('location');
    const latInput = document.getElementById('latitude');
    const longInput = document.getElementById('longitude');
    const btn = document.getElementById('locationBtn');
    
    const address = locationInput.value.trim();
    
    if (!address) {
        alert('Please enter the accident location first');
        locationInput.focus();
        return;
    }
    
    // Show loading state
    btn.disabled = true;
    btn.innerHTML = '🔍 Finding Coordinates...';
    
    try {
        // Using OpenStreetMap Nominatim API (free)
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`);
        const data = await response.json();
        
        if (data && data.length > 0) {
            const lat = parseFloat(data[0].lat).toFixed(6);
            const lon = parseFloat(data[0].lon).toFixed(6);
            
            latInput.value = lat;
            longInput.value = lon;
            
            // Keep inputs readonly and add locked styling
            latInput.setAttribute('readonly', 'readonly');
            longInput.setAttribute('readonly', 'readonly');
            latInput.classList.add('coordinates-locked');
            longInput.classList.add('coordinates-locked');
            
            // Update button to show coordinates are locked
            btn.innerHTML = '🔒 Coordinates Locked';
            btn.style.background = 'linear-gradient(135deg, #059669 0%, #047857 100%)';
            btn.disabled = true;
            
            // Show success message
            setTimeout(() => {
                btn.innerHTML = '✅ Coordinates Set';
            }, 1000);
            
        } else {
            throw new Error('Location not found');
        }
    } catch (error) {
        btn.disabled = false;
        btn.innerHTML = '🔍 Get Coordinates';
        alert('Could not find coordinates for this location. Please enter them manually or try a more specific address.');
        
        // Allow manual input only if auto-fill fails
        latInput.removeAttribute('readonly');
        longInput.removeAttribute('readonly');
        latInput.placeholder = "Enter latitude manually";
        longInput.placeholder = "Enter longitude manually";
    }
}

// Auto-fill coordinates when user finishes typing location (optional)
let locationTimeout;
document.getElementById('location').addEventListener('input', function() {
    clearTimeout(locationTimeout);
    
    // Reset coordinates when location changes
    const latInput = document.getElementById('latitude');
    const longInput = document.getElementById('longitude');
    const btn = document.getElementById('locationBtn');
    
    latInput.value = '';
    longInput.value = '';
    latInput.classList.remove('coordinates-locked');
    longInput.classList.remove('coordinates-locked');
    btn.disabled = false;
    btn.innerHTML = '🔍 Get Coordinates';
    btn.style.background = '';
    
    // Auto-search after user stops typing (optional - remove if you don't want this)
    locationTimeout = setTimeout(() => {
        if (this.value.length > 10) {
            getCoordinatesFromAddress();
        }
    }, 2000); // Wait 2 seconds after user stops typing
});
</script>
    </div>

</body>
</html>
