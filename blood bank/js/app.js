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
    if (window.location.pathname.includes('donor-dashboard.html')) {
        loadDonorHistory();
    }
    if (window.location.pathname.includes('hospital-dashboard.html')) {
        loadBloodStock();
    }
    if (window.location.pathname.includes('bloodbank-dashboard.html')) {
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
        window.location.href = 'donor-dashboard.html';  // Redirect to donor dashboard
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
        window.location.href = 'hospital-dashboard.html';  // Redirect to hospital dashboard
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
        window.location.href = 'bloodbank-dashboard.html';  // Redirect to blood bank dashboard
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

    window.location.href = 'login.html'; // Redirect to login page
});
document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;

    // ---------------- DONOR DASHBOARD ----------------
    if (path.includes("donor-dashboard.html")) {
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
    else if (path.includes("hospital-dashboard.html")) {
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
    else if (path.includes("bloodbank-dashboard.html")) {
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
            window.location.href = "login.html";
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
                window.location.href = "donor-dashboard.html";
            } else if (selectedRole === "hospital") {
                window.location.href = "hospital-dashboard.html";
            } else if (selectedRole === "bloodbank") {
                window.location.href = "bloodbank-dashboard.html";
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
