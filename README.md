## 🩸 BloodVault: Smart Blood Bank Management System

BloodVault is a powerful, full-stack blood bank management system designed for modern healthcare institutions. It digitizes and streamlines blood donation, inventory, and emergency response processes while delivering an intuitive experience for donors, hospitals, and blood banks.

---

### 🔧 Tech Stack

* **Frontend:** HTML, CSS (custom + animations), JavaScript
* **Backend:** PHP
* **Database:** MySQL
* **Tools & Libraries:**

  * Leaflet.js (interactive blood bank map)
  * JavaScript chatbot with AI-like logic
  * PHP Sessions for user handling

---

## 🧩 Core Modules (Formal Breakdown)

### 👤 Role-based Authentication

* Separate login access for **Donors**, **Hospitals**, and **Blood Banks**.
* Central `MobileUser` table linked with individual role tables.
* Session-controlled dashboards showing only role-specific data.

### 🧾 Registration System

* Dynamic registration form based on selected role.
* Adds user to both `MobileUser` and respective tables like `Donor`, `Hospital`, or `BloodCenter`.
* Stores medical, demographic, and contact data.

### 🏥 Blood Request Management

* Hospitals can submit **regular** or **emergency** blood requests.
* Validated via custom PHP/JS logic.
* Tracked in `BloodRequest` and `EmergencyBloodRequest` tables.

### 👨‍⚕️ Donor Dashboard

* Profile summary, blood type, last donation, and health status.
* Real-time donation history with visual UI and achievement badges.

### 🏢 Hospital Dashboard

* Display hospital info and raise/view blood requests.
* Secure access to hospital's own entries.

### 🩸 Blood Bank Dashboard

* Shows blood center details, staff, and pending emergency requests.
* Manage `Staff`, approve emergency needs, and check blood stocks.

### 🤖 AI Prediction & Chatbot

* Displays `AI_Prediction` table for blood needs per accident.
* Custom chatbot with **typing animation** and **Enter-key support**.
* Trained on 100+ Q\&A around AI, blood needs, donations, and system use.

### 📍 Interactive Map

* Map of all blood banks using **Leaflet.js** and coordinates.
* Clickable markers for details like location and contact.

### 📢 Awareness Campaigns

* List and add upcoming health campaigns.
* Filters out outdated events based on start and end dates.

---

## 🎉 The Fun Version

> A creative, life-saving digital playground where donors, hospitals, and blood centers high-five each other via PHP and JavaScript! 💉❤️

### 🌟 Highlights

* Role-based dashboards = **no peeking into someone else's blood!** 🕵️
* 100+ AI chatbot questions = **Ask away! Even weird stuff.** 🤖
* Real-time forms, health tracking, and donation badges = **Because heroes deserve medals.** 🏅
* Interactive blood bank map = **Where in the world is my O+ blood?** 🗺️
* Auto-validated forms = **No more "Oops, forgot that field!"**

---

## 🔐 Key Features

* ✅ Custom dashboards with secure session login
* ✅ Emergency request tracker with timestamps
* ✅ AI chatbot with smart replies and loading animation
* ✅ Leaflet.js-based blood bank locator
* ✅ Donor achievements with badge animations
* ✅ Admin-level staff management & salary records
* ✅ Campaign management for social awareness

---

## 🚀 Coming Soon

* 🩸 Live blood stock status
* 📊 Real-time admin analytics
* 📄 Report generation (PDFs!)
* 🔔 Email notifications for requests
* 🧠 AI-powered donor suggestions

---

## 👨‍💻 Built By

A passionate college-level full-stack developer solving real-world problems with clean UI, smart backend logic, and a dose of compassion.

> This is more than code. It's a **mission to save lives.**
