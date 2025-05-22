<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Blood - Hospital</title>
    <script>
        function validateRequestForm() {
            const bloodType = document.getElementById("bloodType").value;
            const quantity = document.getElementById("quantity").value;

            if (bloodType === "" || quantity === "" || parseInt(quantity) <= 0) {
                alert("Please fill all required fields correctly.");
                return false;
            }

            alert("Request submitted successfully!");
            return true;
        }
    </script>
    <link rel="stylesheet" href="newrequest-style.css">
</head>

<body>
    <div class="progress-container">
        <div class="progress-bar" id="formProgress"></div>
      </div>
    <div class="form-header">
        <h2>Hospital Blood Request</h2>
        <p>Please complete all required fields to submit your blood request</p>
      </div>
      <form onsubmit="return validateRequestForm()" method="POST" action="/submit-blood-request">
      <div class="form-section">
        <!-- Hospital information fields -->
        <label for="hospitalName">Hospital Name:</label><br>
        <input type="text" id="hospitalName" name="hospitalName" required><br><br>

        <label for="hospitalID">Hospital ID (if any):</label><br>
        <input type="text" id="hospitalID" name="hospitalID"><br><br>

        <label for="contactPerson">Contact Person:</label><br>
        <input type="text" id="contactPerson" name="contactPerson" required><br><br>

        <label for="contactNumber">Contact Number:</label><br>
        <input type="tel" id="contactNumber" name="contactNumber" required><br><br>

        <label for="email">Email Address:</label><br>
        <input type="email" id="email" name="email"><br><br>
          
        <label for="hospitalAddress">Hospital Address:</label><br>
        <textarea id="hospitalAddress" name="hospitalAddress" rows="3" cols="50"></textarea><br><br>

      </div>
      <div class="form-section">
        <!-- Blood request details -->
        <label for="bloodType">Required Blood Type:</label><br>
        <select id="bloodType" name="bloodType" required>
            <option value="">-- Select --</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
        </select><br><br>

        <label for="quantity">Quantity (in units):</label><br>
        <input type="number" id="quantity" name="quantity" min="1" required><br><br>

        <label for="urgency">Urgency Level:</label><br>
        <select id="urgency" name="urgency" required>
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
            <option value="Critical">Critical</option>
        </select><br><br>

        <label for="requiredDate">Date Blood is Needed:</label><br>
        <input type="date" id="requiredDate" name="requiredDate" required><br><br>

        <label for="reason">Reason for Request / Patient Condition:</label><br>
        <textarea id="reason" name="reason" rows="4" cols="50" required></textarea><br><br>

      </div>
    
        
   </form>
      
        <button type="submit">Submit Blood Request</button>
    </form>
    <script src="js/app.js"></script>
</body>
</html>
