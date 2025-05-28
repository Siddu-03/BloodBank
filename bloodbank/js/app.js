// For example, to fetch and display donor history (Donor Dashboard)
function loadDonorHistory() {
    fetch('/api/donor-history')  // Replace with actual backend API
        .then(response => response.json())
        .then(data => {
            const historyTable = document.getElementById('donationHistory');
            data.forEach(donation => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${donation.date}</td>
                    <td>${donation.bloodType}</td>
                    <td>${donation.amount}</td>
                `;
                historyTable.appendChild(row);
            });
        });
}

// For example, to fetch and display available blood stock (Hospital Dashboard)
function loadBloodStock() {
    fetch('/api/blood-stock')  // Replace with actual backend API
        .then(response => response.json())
        .then(data => {
            const stockTable = document.getElementById('bloodStock');
            data.forEach(stock => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${stock.bloodType}</td>
                    <td>${stock.availableUnits}</td>
                `;
                stockTable.appendChild(row);
            });
        });
}

// For example, to load blood inventory (Blood Bank Dashboard)
function loadBloodInventory() {
    fetch('/api/blood-inventory')  // Replace with actual backend API
        .then(response => response.json())
        .then(data => {
            const inventoryTable = document.getElementById('inventoryList');
            data.forEach(inventory => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${inventory.bloodType}</td>
                    <td>${inventory.totalUnits}</td>
                    <td>${inventory.availableUnits}</td>
                    <td><button class="update-btn">Update</button></td>
                `;
                inventoryTable.appendChild(row);
            });
        });
}

// Call respective functions to load data on page load
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname.includes('donor-dashboard.php')) {
        loadDonorHistory();
    }
    if (window.location.pathname.includes('hospital-dashboard.php')) {
        loadBloodStock();
    }
    if (window.location.pathname.includes('bloodbank-dashboard.php')) {
        loadBloodInventory();
    }
});
// Donor Login Form Logic
document.getElementById('donorLoginForm')?.addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('donorEmail').value;
    const password = document.getElementById('donorPassword').value;

    // Mock check for donor login, replace with actual API call
    if (email === 'donor@example.com' && password === 'password123') {
        alert('Login successful');
        window.location.href = 'donor-dashboard.php';  // Redirect to donor dashboard
    } else {
        alert('Invalid credentials');
    }
});

// Hospital Login Form Logic
document.getElementById('hospitalLoginForm')?.addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('hospitalEmail').value;
    const password = document.getElementById('hospitalPassword').value;

    // Mock check for hospital login, replace with actual API call
    if (email === 'hospital@example.com' && password === 'hospital123') {
        alert('Login successful');
        window.location.href = 'hospital-dashboard.php';  // Redirect to hospital dashboard
    } else {
        alert('Invalid credentials');
    }
});

// Blood Bank Login Form Logic
document.getElementById('bloodBankLoginForm')?.addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('bloodBankEmail').value;
    const password = document.getElementById('bloodBankPassword').value;

    // Mock check for blood bank login, replace with actual API call
    if (email === 'bloodbank@example.com' && password === 'bloodbank123') {
        alert('Login successful');
        window.location.href = 'bloodbank-dashboard.php';  // Redirect to blood bank dashboard
    } else {
        alert('Invalid credentials');
    }
});
// Example: Populating donor data dynamically
document.addEventListener("DOMContentLoaded", () => {
    const donorName = "John Doe"; // Fetch from backend
    const bloodType = "A+";       // Fetch from backend
    const history = [
        { date: "2025-04-01", bloodType: "A+", amount: "1 unit" },
        { date: "2024-12-15", bloodType: "A+", amount: "1 unit" },
    ];

    document.getElementById("donorName").textContent = donorName;
    document.getElementById("bloodType").textContent = bloodType;

    const tbody = document.getElementById("donationHistory");
    history.forEach(donation => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${donation.date}</td>
            <td>${donation.bloodType}</td>
            <td>${donation.amount}</td>
        `;
        tbody.appendChild(row);
    });
});
document.getElementById('logoutBtn').addEventListener('click', () => {
    // Optional: clear session/local storage if used
    // localStorage.clear();
    // sessionStorage.clear();

    window.location.href = 'login.php'; // Redirect to login page
});
document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;

    // ---------------- DONOR DASHBOARD ----------------
    if (path.includes("donor-dashboard.php")) {
        fetch("http://localhost:3000/api/donor/dashboard", {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("donorName").textContent = data.name;
            document.getElementById("bloodType").textContent = data.bloodType;

            const historyTable = document.getElementById("donationHistory");
            data.donations.forEach(donation => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${donation.date}</td>
                    <td>${donation.bloodType}</td>
                    <td>${donation.amount}</td>
                `;
                historyTable.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching donor data:", error));
    }

    // ---------------- HOSPITAL DASHBOARD ----------------
    else if (path.includes("hospital-dashboard.php")) {
        fetch("http://localhost:3000/api/hospital/dashboard", {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("hospitalName").textContent = data.name;

            const requestTable = document.getElementById("requestHistory");
            data.requests.forEach(request => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${request.date}</td>
                    <td>${request.bloodType}</td>
                    <td>${request.units}</td>
                    <td>${request.status}</td>
                `;
                requestTable.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching hospital data:", error));
    }

    // ---------------- BLOOD BANK DASHBOARD ----------------
    else if (path.includes("bloodbank-dashboard.php")) {
        fetch("http://localhost:3000/api/bloodbank/dashboard", {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("bankName").textContent = data.name;

            const stockTable = document.getElementById("stockData");
            data.stock.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.bloodType}</td>
                    <td>${item.units}</td>
                `;
                stockTable.appendChild(row);
            });

            const requestList = document.getElementById("hospitalRequests");
            data.hospitalRequests.forEach(req => {
                const li = document.createElement("li");
                li.textContent = `${req.units} units of ${req.bloodType} requested by ${req.hospitalName}`;
                requestList.appendChild(li);
            });
        })
        .catch(error => console.error("Error fetching blood bank data:", error));
    }

    // ---------------- LOGOUT BUTTON FOR ALL ----------------
    const logoutBtn = document.getElementById("logoutBtn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
            // localStorage.clear(); // if you store token/id
            window.location.href = "login.php";
        });
    }
});
let selectedRole = "hospital"; // default

// Role selection buttons
document.querySelectorAll(".role-btn").forEach(button => {
    button.addEventListener("click", () => {
        // Remove active from all
        document.querySelectorAll(".role-btn").forEach(btn => btn.classList.remove("active"));
        
        // Add active to clicked one
        button.classList.add("active");
        selectedRole = button.getAttribute("data-role"); // donor, hospital, bloodbank
    });
});

document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    fetch("http://localhost:3000/api/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ username, password, role: selectedRole })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Redirect to the correct dashboard
            if (selectedRole === "donor") {
                window.location.href = "donor-dashboard.php";
            } else if (selectedRole === "hospital") {
                window.location.href = "hospital-dashboard.php";
            } else if (selectedRole === "bloodbank") {
                window.location.href = "bloodbank-dashboard.php";
            }
        } else {
            alert("Invalid credentials. Please try again.");
        }
    })
    .catch(err => {
        console.error("Login error:", err);
        alert("Something went wrong. Try again later.");
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const particlesContainer = document.getElementById('particles-js');
    const particleCount = 20;

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        const size = Math.floor(Math.random() * 80) + 20;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        const posX = Math.floor(Math.random() * 100);
        const posY = Math.floor(Math.random() * 100) + 100;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;
        const duration = Math.floor(Math.random() * 20) + 15;
        particle.style.animationDuration = `${duration}s`;
        const delay = Math.floor(Math.random() * 10);
        particle.style.animationDelay = `${delay}s`;
        particlesContainer.appendChild(particle);
    }

    document.querySelectorAll('.form-group input').forEach(input => {
        input.addEventListener('focus', e => e.target.parentElement.classList.add('focus'));
        input.addEventListener('blur', e => e.target.parentElement.classList.remove('focus'));
    });

    const roleButtons = document.querySelectorAll('.role-btn');
    const roleInput = document.getElementById('role');
    roleButtons.forEach(button => {
        button.addEventListener('click', function () {
            roleButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            roleInput.value = this.getAttribute('data-role');
        });
    });

    const loginForm = document.getElementById('login-form');
    const notification = document.getElementById('notification');
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(loginForm);
        const button = document.querySelector('.btn-login');
        button.classList.add('loading');

        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            button.classList.remove('loading');
            if (data.status === 'success') {
                notification.textContent = `Login successful! Redirecting to ${formData.get('role')} dashboard...`;
                notification.classList.add('show');
                setTimeout(() => {
                    window.location.href = `${formData.get('role')}-dashboard.php`;
                }, 2000);
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            button.classList.remove('loading');
            alert('An error occurred. Please try again.');
            console.error(err);
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const emailInput = document.querySelector("input[name='email']");
    const passwordInput = document.querySelector("input[name='password']");

    form.addEventListener("submit", function (e) {
        if (emailInput.value.trim() === "" || passwordInput.value.trim() === "") {
            e.preventDefault();
            alert("Please enter both email and password.");
        }
    });
});
/* Initialize blood cells and elements in the DOM with JavaScript */
document.addEventListener('DOMContentLoaded', function() {
  // Create blood cells container
  const bloodCellsContainer = document.createElement('div');
  bloodCellsContainer.className = 'blood-cells-container';
  
  // Create individual blood cells
  for (let i = 1; i <= 6; i++) {
    const bloodCell = document.createElement('div');
    bloodCell.className = 'blood-cell';
    bloodCellsContainer.appendChild(bloodCell);
  }
  
  document.body.appendChild(bloodCellsContainer);
  
  // Create decorative elements
  const bloodDrop = document.createElement('div');
  bloodDrop.className = 'blood-drop';
  document.body.appendChild(bloodDrop);
  
  // Add form decorations
  const formElement = document.querySelector('form');
  if (formElement) {
    const decoration1 = document.createElement('div');
    decoration1.className = 'form-decoration decoration-1';
    const decoration2 = document.createElement('div');
    decoration2.className = 'form-decoration decoration-2';
    formElement.appendChild(decoration1);
    formElement.appendChild(decoration2);
    
    // Add pulse element behind the form
    const pulseElement = document.createElement('div');
    pulseElement.className = 'pulse-element';
    pulseElement.style.left = '-100px';
    pulseElement.style.top = '50px';
    formElement.appendChild(pulseElement);
    
    // Add form footer
    const formFooter = document.createElement('div');
    formFooter.className = 'form-footer';
    formFooter.textContent = 'Thank you for registering with our blood donation system';
    formElement.appendChild(formFooter);
    
    // Create DNA loader
    const dnaLoader = document.createElement('div');
    dnaLoader.className = 'dna-loader';
    for (let i = 1; i <= 12; i++) {
      const bar = document.createElement('div');
      bar.className = 'bar';
      dnaLoader.appendChild(bar);
    }
    formElement.appendChild(dnaLoader);
    
    // Add section icons to each section
    const sections = ['donorFields', 'bloodBankFields', 'hospitalFields'];
    sections.forEach(function(sectionId) {
      const section = document.getElementById(sectionId);
      if (section) {
        const sectionIcon = document.createElement('div');
        sectionIcon.className = 'section-icon';
        section.appendChild(sectionIcon);
      }
    });
  }
  
  // Add interactive classes to form elements
  const formInputs = document.querySelectorAll('input, select, textarea');
  formInputs.forEach(function(input) {
    const parentDiv = document.createElement('div');
    parentDiv.className = 'interactive-field';
    input.parentNode.insertBefore(parentDiv, input);
    parentDiv.appendChild(input);
  });
  
  // Add liquid button effect
  const button = document.querySelector('button');
  if (button) {
    button.classList.add('liquid-btn');
  }
  
  // Add password strength visualization
  const passwordFields = document.querySelectorAll('input[type="password"]');
  passwordFields.forEach(function(passwordField) {
    const passwordDiv = document.createElement('div');
    passwordDiv.className = 'password-field';
    passwordField.parentNode.insertBefore(passwordDiv, passwordField);
    passwordDiv.appendChild(passwordField);
    
    const strengthIndicator = document.createElement('div');
    strengthIndicator.className = 'password-strength';
    passwordDiv.appendChild(strengthIndicator);
    
    // Password strength check
    passwordField.addEventListener('input', function() {
      const value = this.value;
      let width = 0;
      
      if (value.length > 0) width = 20;
      if (value.length > 6) width = 40;
      if (value.length > 8) width = 60;
      if (/[A-Z]/.test(value) && /[a-z]/.test(value)) width = 80;
      if (/[0-9]/.test(value) && /[^A-Za-z0-9]/.test(value)) width = 100;
      
      strengthIndicator.style.setProperty('--strength-width', width + '%');
    });
  });
});
// Progress Bar Animation
document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.getElementById('formProgress');
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    function updateProgress() {
        let filledInputs = 0;
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                filledInputs++;
            }
        });
        
        const progress = (filledInputs / inputs.length) * 100;
        progressBar.style.width = progress + '%';
    }
    
    // Update progress on input change
    inputs.forEach(input => {
        input.addEventListener('input', updateProgress);
        input.addEventListener('change', updateProgress);
    });
    
    // Initial progress calculation
    updateProgress();
    
    // Submit button loading state
    form.addEventListener('submit', function() {
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.classList.add('loading');
        submitBtn.textContent = 'Submitting...';
    });
});