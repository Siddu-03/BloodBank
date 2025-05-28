CREATE DATABASE dbbb;
USE dbbb;

-- Donor Table
CREATE TABLE Donor (
    DonorID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Age INT,
    BloodType VARCHAR(5),
    Contact VARCHAR(15),
    LastDonationDate DATE,
    HealthStatus VARCHAR(255)
);

-- Hospital Table
CREATE TABLE Hospital (
    HospitalID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Address VARCHAR(255),
    Contact VARCHAR(15)
);

-- Recipient Table
CREATE TABLE Recipient (
    RecipientID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Age INT,
    BloodType VARCHAR(5),
    Contact VARCHAR(15),
    RequiredUnits INT,
    HospitalID INT,
    FOREIGN KEY (HospitalID) REFERENCES Hospital(HospitalID)
);

-- BloodCenter Table with lat/lng
CREATE TABLE BloodCenter (
    BloodCenterID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Location VARCHAR(255),
    Latitude DECIMAL(10, 8),
    Longitude DECIMAL(11, 8),
    Contact VARCHAR(15)
);

-- BloodInventory Table
CREATE TABLE BloodInventory (
    BloodID INT PRIMARY KEY AUTO_INCREMENT,
    BloodType VARCHAR(5),
    Quantity INT,
    ExpiryDate DATE,
    StorageLocation VARCHAR(100),
    BloodCenterID INT,
    FOREIGN KEY (BloodCenterID) REFERENCES BloodCenter(BloodCenterID)
);

-- BloodRequest Table
CREATE TABLE BloodRequest (
    RequestID INT PRIMARY KEY AUTO_INCREMENT,
    RecipientID INT,
    BloodType VARCHAR(5),
    UnitsRequested INT,
    RequestStatus ENUM('Pending', 'Approved', 'Completed'),
    RequestDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RecipientID) REFERENCES Recipient(RecipientID)
);

-- AccidentReport Table with lat/lng
CREATE TABLE AccidentReport (
    AccidentID INT PRIMARY KEY AUTO_INCREMENT,
    Location VARCHAR(255),
    Latitude DECIMAL(10, 8),
    Longitude DECIMAL(11, 8),
    Severity ENUM('Low', 'Moderate', 'Severe'),
    CasualtyCount INT,
    ReportedBy VARCHAR(100),
    ReportTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- EmergencyBloodRequest Table
CREATE TABLE EmergencyBloodRequest (
    EmergencyRequestID INT PRIMARY KEY AUTO_INCREMENT,
    AccidentID INT,
    RequiredBloodType VARCHAR(5),
    RequiredUnits INT,
    NearestBloodCenterID INT,
    Status ENUM('Pending', 'Approved', 'Completed'),
    RequestTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AccidentID) REFERENCES AccidentReport(AccidentID),
    FOREIGN KEY (NearestBloodCenterID) REFERENCES BloodCenter(BloodCenterID)
);

-- Transaction Table
CREATE TABLE Transaction (
    TransactionID INT PRIMARY KEY AUTO_INCREMENT,
    DonorID INT,
    RecipientID INT,
    BloodID INT,
    Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Type ENUM('Donation', 'Issue'),
    FOREIGN KEY (DonorID) REFERENCES Donor(DonorID),
    FOREIGN KEY (RecipientID) REFERENCES Recipient(RecipientID),
    FOREIGN KEY (BloodID) REFERENCES BloodInventory(BloodID)
);

-- Staff Table
CREATE TABLE Staff (
    StaffID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Role ENUM('Admin', 'Technician', 'Nurse'),
    Contact VARCHAR(15),
    Shift VARCHAR(20),
    Salary DECIMAL(10,2)
);

-- AwarenessCampaign Table
CREATE TABLE AwarenessCampaign (
    CampaignID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    TargetAudience VARCHAR(255),
    StartDate DATE,
    EndDate DATE,
    Outcome TEXT
);

-- MobileUser Table
CREATE TABLE MobileUser (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    PhoneNumber VARCHAR(15),
    PasswordHash VARCHAR(255),
    Role ENUM('Donor', 'Recipient', 'Hospital', 'Admin')
);

-- AI_Prediction Table
CREATE TABLE AI_Prediction (
    PredictionID INT PRIMARY KEY AUTO_INCREMENT,
    AccidentID INT,
    PredictedBloodType VARCHAR(5),
    PredictedUnits INT,
    PredictionConfidence FLOAT,
    PredictionDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AccidentID) REFERENCES AccidentReport(AccidentID)
);
-- Insert into Donor
INSERT INTO Donor (Name, Age, BloodType, Contact, LastDonationDate, HealthStatus) VALUES
('John Doe', 28, 'A+', '9876543210', '2025-03-15', 'Healthy'),
('Jane Smith', 34, 'B-', '9876543211', '2025-02-10', 'Healthy'),
('Alice Brown', 22, 'O+', '9876543212', '2025-04-01', 'Minor Cold'),
('Chris Evans', 30, 'AB+', '9876543213', '2025-01-20', 'Healthy'),
('Natalie Portman', 27, 'O-', '9876543214', '2024-12-10', 'Healthy'),
('Robert Downey', 40, 'B+', '9876543215', '2025-02-25', 'Diabetic'),
('Scarlett Johansson', 31, 'A-', '9876543216', '2025-03-05', 'Healthy'),
('Tom Holland', 25, 'O+', '9876543217', '2025-03-30', 'Healthy'),
('Zendaya Maree', 26, 'AB-', '9876543218', '2025-04-05', 'Healthy'),
('Benedict Cumberbatch', 38, 'B+', '9876543219', '2025-03-12', 'Healthy');

-- Insert into Hospital
INSERT INTO Hospital (Name, Address, Contact) VALUES
('City Hospital', '123 Main St', '9000000001'),
('Green Valley Hospital', '45 Park Lane', '9000000002'),
('Sunrise Medical', '67 Lakeview', '9000000003'),
('Hope Hospital', '89 Forest Dr', '9000000004'),
('Riverfront Medical', '12 River Rd', '9000000005'),
('Unity Hospital', '34 Unity Plaza', '9000000006'),
('Community Care', '56 Community St', '9000000007'),
('Metro Health', '78 Metro Blvd', '9000000008'),
('Silver Line Clinic', '90 Silver St', '9000000009'),
('Golden Heart Hospital', '101 Gold Rd', '9000000010');

-- Insert into Recipient
INSERT INTO Recipient (Name, Age, BloodType, Contact, RequiredUnits, HospitalID) VALUES
('Mike Taylor', 40, 'A+', '9876540001', 2, 1),
('Laura Johnson', 29, 'B-', '9876540002', 1, 2),
('Mark Lee', 55, 'O+', '9876540003', 3, 3),
('Anna Kim', 33, 'AB+', '9876540004', 2, 4),
('Peter Parker', 21, 'O+', '9876540005', 1, 5),
('Tony Stark', 45, 'B+', '9876540006', 4, 6),
('Steve Rogers', 100, 'A-', '9876540007', 2, 7),
('Natasha Romanoff', 35, 'O-', '9876540008', 2, 8),
('Bruce Banner', 39, 'AB-', '9876540009', 3, 9),
('Clint Barton', 38, 'B+', '9876540010', 1, 10);

-- Insert into BloodCenter
INSERT INTO BloodCenter (Name, Location, Latitude, Longitude, Contact) VALUES
('Central Blood Center', 'Downtown', 40.712776, -74.005974, '9123456789'),
('North Blood Center', 'North Area', 40.750000, -73.950000, '9234567890'),
('South Blood Center', 'South Park', 40.700000, -73.900000, '9345678901'),
('East Blood Center', 'East End', 40.730610, -73.935242, '9456789012'),
('West Blood Center', 'Westfield', 40.740000, -74.020000, '9567890123'),
('City Blood Bank', 'City Center', 40.720000, -74.000000, '9678901234'),
('Uptown Blood Center', 'Uptown', 40.760000, -73.980000, '9789012345'),
('Suburban Blood Bank', 'Suburbia', 40.670000, -73.950000, '9890123456'),
('Harbor Blood Center', 'Harbor Area', 40.710000, -74.010000, '9901234567'),
('Midtown Blood Center', 'Midtown', 40.754932, -73.984016, '9012345678');

-- Insert into BloodInventory
INSERT INTO BloodInventory (BloodType, Quantity, ExpiryDate, StorageLocation, BloodCenterID) VALUES
('A+', 10, '2025-06-30', 'Storage A', 1),
('B-', 5, '2025-05-15', 'Storage B', 2),
('O+', 15, '2025-06-10', 'Storage C', 3),
('AB+', 8, '2025-07-01', 'Storage D', 4),
('O-', 12, '2025-05-30', 'Storage E', 5),
('B+', 20, '2025-06-20', 'Storage F', 6),
('A-', 9, '2025-06-25', 'Storage G', 7),
('AB-', 3, '2025-07-10', 'Storage H', 8),
('A+', 18, '2025-07-15', 'Storage I', 9),
('B+', 7, '2025-06-18', 'Storage J', 10);

-- Insert into BloodRequest
INSERT INTO BloodRequest (RecipientID, BloodType, UnitsRequested, RequestStatus) VALUES
(1, 'A+', 2, 'Pending'),
(2, 'B-', 1, 'Approved'),
(3, 'O+', 3, 'Pending'),
(4, 'AB+', 2, 'Completed'),
(5, 'O+', 1, 'Pending'),
(6, 'B+', 4, 'Approved'),
(7, 'A-', 2, 'Pending'),
(8, 'O-', 2, 'Completed'),
(9, 'AB-', 3, 'Pending'),
(10, 'B+', 1, 'Pending');

-- Insert into AccidentReport
INSERT INTO AccidentReport (Location, Latitude, Longitude, Severity, CasualtyCount, ReportedBy) VALUES
('Highway 21', 40.755556, -73.986389, 'Severe', 3, 'Officer Dan'),
('Bridge Road', 40.741111, -74.004167, 'Moderate', 1, 'Citizen Lee'),
('City Center', 40.712776, -74.005974, 'Low', 1, 'Officer Jane'),
('Mountain Pass', 40.780000, -73.970000, 'Severe', 5, 'Citizen Max'),
('Ocean Drive', 40.710000, -74.010000, 'Moderate', 2, 'Officer Kim'),
('Forest Trail', 40.730000, -74.000000, 'Severe', 4, 'Ranger Sam'),
('Desert Road', 40.720000, -73.950000, 'Low', 1, 'Traveler Joe'),
('Airport Rd', 40.750000, -73.940000, 'Moderate', 2, 'Traffic Officer'),
('River Bridge', 40.740000, -74.020000, 'Severe', 3, 'Citizen Alex'),
('Market Street', 40.730610, -73.935242, 'Low', 1, 'Patrol Officer');

-- Insert into EmergencyBloodRequest
INSERT INTO EmergencyBloodRequest (AccidentID, RequiredBloodType, RequiredUnits, NearestBloodCenterID, Status) VALUES
(1, 'A+', 4, 1, 'Pending'),
(2, 'O+', 2, 2, 'Approved'),
(3, 'B-', 3, 3, 'Pending'),
(4, 'AB+', 5, 4, 'Pending'),
(5, 'O-', 2, 5, 'Approved'),
(6, 'A+', 3, 6, 'Pending'),
(7, 'B+', 1, 7, 'Completed'),
(8, 'O+', 2, 8, 'Approved'),
(9, 'A-', 3, 9, 'Pending'),
(10, 'AB-', 1, 10, 'Pending');

-- Insert into Transaction
INSERT INTO Transaction (DonorID, RecipientID, BloodID, Type) VALUES
(1, 1, 1, 'Donation'),
(2, 2, 2, 'Donation'),
(3, 3, 3, 'Donation'),
(4, 4, 4, 'Donation'),
(5, 5, 5, 'Donation'),
(6, 6, 6, 'Donation'),
(7, 7, 7, 'Donation'),
(8, 8, 8, 'Donation'),
(9, 9, 9, 'Donation'),
(10, 10, 10, 'Donation');

-- Insert into Staff
INSERT INTO Staff (Name, Role, Contact, Shift, Salary) VALUES
('Emma Watson', 'Admin', '9012345001', 'Morning', 50000.00),
('Daniel Radcliffe', 'Technician', '9012345002', 'Evening', 35000.00),
('Rupert Grint', 'Nurse', '9012345003', 'Night', 30000.00),
('Tom Felton', 'Technician', '9012345004', 'Morning', 36000.00),
('Bonnie Wright', 'Nurse', '9012345005', 'Evening', 31000.00),
('Matthew Lewis', 'Admin', '9012345006', 'Night', 51000.00),
('Evanna Lynch', 'Technician', '9012345007', 'Morning', 34000.00),
('James Phelps', 'Nurse', '9012345008', 'Evening', 32000.00),
('Oliver Phelps', 'Nurse', '9012345009', 'Night', 33000.00),
('Robbie Coltrane', 'Admin', '9012345010', 'Morning', 52000.00);

-- Insert into AwarenessCampaign
INSERT INTO AwarenessCampaign (Name, TargetAudience, StartDate, EndDate, Outcome) VALUES
('Donate Blood Save Life', 'General Public', '2025-05-01', '2025-05-10', 'Increased Donors'),
('Blood Awareness Week', 'Students', '2025-06-01', '2025-06-07', 'Positive Feedback'),
('Health Fair 2025', 'Working Professionals', '2025-07-15', '2025-07-20', 'Good Participation'),
('Blood Drive Marathon', 'Sports Enthusiasts', '2025-08-05', '2025-08-12', 'High Turnout'),
('Women Health Camp', 'Women', '2025-09-01', '2025-09-05', 'Well Received'),
('Senior Citizen Health Day', 'Senior Citizens', '2025-10-01', '2025-10-05', 'Moderate'),
('Youth Blood Drive', 'Youth', '2025-11-01', '2025-11-07', 'Excellent Participation'),
('Mega Blood Donation', 'Everyone', '2025-12-01', '2025-12-10', 'Record Breaking'),
('Emergency Blood Support', 'Urban Areas', '2026-01-15', '2026-01-20', 'Successful'),
('Rural Health Awareness', 'Villagers', '2026-02-01', '2026-02-05', 'Needs Improvement');

-- Insert into MobileUser
INSERT INTO MobileUser (Name, Email, PhoneNumber, PasswordHash, Role) VALUES
('John Doe', 'john@example.com', '9876543210', 'passwordhash1', 'Donor'),
('Jane Smith', 'jane@example.com', '9876543211', 'passwordhash2', 'Recipient'),
('Alice Brown', 'alice@example.com', '9876543212', 'passwordhash3', 'Donor'),
('Chris Evans', 'chris@example.com', '9876543213', 'passwordhash4', 'Donor'),
('Robert Downey', 'robert@example.com', '9876543215', 'passwordhash5', 'Donor'),
('Tony Stark', 'tony@example.com', '9876540006', 'passwordhash6', 'Recipient'),
('Natasha Romanoff', 'natasha@example.com', '9876540008', 'passwordhash7', 'Recipient'),
('Peter Parker', 'peter@example.com', '9876540005', 'passwordhash8', 'Recipient'),
('Dr. Strange', 'strange@example.com', '9876543220', 'passwordhash9', 'Hospital'),
('Bruce Wayne', 'bruce@example.com', '9876543221', 'passwordhash10', 'Admin');

-- Insert into AI_Prediction
INSERT INTO AI_Prediction (AccidentID, PredictedBloodType, PredictedUnits, PredictionConfidence) VALUES
(1, 'A+', 4, 0.92),
(2, 'O+', 2, 0.88),
(3, 'B-', 3, 0.85),
(4, 'AB+', 5, 0.90),
(5, 'O-', 2, 0.86),
(6, 'A+', 3, 0.89),
(7, 'B+', 1, 0.91),
(8, 'O+', 2, 0.87),
(9, 'A-', 3, 0.84),
(10, 'AB-', 1, 0.83);
