CREATE DATABASE dbbb;
USE dbbb;


CREATE TABLE Donor (
    DonorID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Age INT,
    BloodType VARCHAR(5),
    Contact VARCHAR(15),
    LastDonationDate DATE,
    HealthStatus VARCHAR(255)
);

CREATE TABLE Hospital (
    HospitalID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Address VARCHAR(255),
    Contact VARCHAR(15)
);


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

CREATE TABLE BloodCenter (
    BloodCenterID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Location VARCHAR(255),
    Contact VARCHAR(15)
);


CREATE TABLE BloodInventory (
    BloodID INT PRIMARY KEY AUTO_INCREMENT,
    BloodType VARCHAR(5),
    Quantity INT,
    ExpiryDate DATE,
    StorageLocation VARCHAR(100),
    BloodCenterID INT,
    FOREIGN KEY (BloodCenterID) REFERENCES BloodCenter(BloodCenterID)
);

CREATE TABLE BloodRequest (
    RequestID INT PRIMARY KEY AUTO_INCREMENT,
    RecipientID INT,
    BloodType VARCHAR(5),
    UnitsRequested INT,
    RequestStatus ENUM('Pending', 'Approved', 'Completed'),
    RequestDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RecipientID) REFERENCES Recipient(RecipientID)
);

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


CREATE TABLE AccidentReport (
    AccidentID INT PRIMARY KEY AUTO_INCREMENT,
    Location VARCHAR(255),
    Severity ENUM('Low', 'Moderate', 'Severe'),
    CasualtyCount INT,
    ReportedBy VARCHAR(100),
    ReportTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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


CREATE TABLE Staff (
    StaffID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Role ENUM('Admin', 'Technician', 'Nurse'),
    Contact VARCHAR(15),
    Shift VARCHAR(20),
    Salary DECIMAL(10,2)
);

CREATE TABLE AwarenessCampaign (
    CampaignID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    TargetAudience VARCHAR(255),
    StartDate DATE,
    EndDate DATE,
    Outcome TEXT
);

CREATE TABLE MobileUser (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    PhoneNumber VARCHAR(15),
    PasswordHash VARCHAR(255),
    Role ENUM('Donor', 'Recipient', 'Hospital', 'Admin')
);

CREATE TABLE AI_Prediction (
    PredictionID INT PRIMARY KEY AUTO_INCREMENT,
    AccidentID INT,
    PredictedBloodType VARCHAR(5),
    PredictedUnits INT,
    PredictionConfidence FLOAT,
    PredictionDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AccidentID) REFERENCES AccidentReport(AccidentID)
);