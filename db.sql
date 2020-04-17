#CREATE TABLES

CREATE TABLE IF NOT EXISTS Store(
    SID CHAR(4) PRIMARY KEY,
    address VARCHAR(100),
    manager CHAR(4) NOT NULL UNIQUE,
    FOREIGN KEY (Manager) REFERENCES Employee(EID)
);


CREATE TABLE IF NOT EXISTS Employee (
    EID CHAR(4) PRIMARY KEY,
    pwhash CHAR(32) NOT NULL,
    location CHAR(4),
    name VARCHAR(100),
    salary DECIMAL(8,2) NOT NULL,
    address VARCHAR(100),
    FOREIGN KEY (location) REFERENCES Store (SID)
);


CREATE TABLE IF NOT EXISTS Customer (
    email VARCHAR(20) PRIMARY KEY,
    pwhash CHAR(32) NOT NULL,
    name VARCHAR(100),
    address VARCHAR(100)
);



CREATE TABLE IF NOT EXISTS Customer_Transactions (
    email VARCHAR(20),
    TID CHAR(4),
    PRIMARY KEY (email, TID),
    FOREIGN KEY (email) REFERENCES Customer (email),
    FOREIGN KEY (TID) REFERENCES Transaction (TID)
);



CREATE TABLE IF NOT EXISTS Transaction (
    TID CHAR(4) PRIMARY KEY,
    cashier CHAR(4) NOT NULL,
    FOREIGN KEY (cashier) REFERENCES Employee (EID),
    FOREIGN KEY (TID) REFERENCES Transaction (TID)
);


CREATE TABLE IF NOT EXISTS Supervise (
    shift_lead CHAR(4),
    employee CHAR(4),
    PRIMARY KEY (shift_lead, employee),
    FOREIGN KEY (shift_lead) REFERENCES Employee (EID),
    FOREIGN KEY (employee) REFERENCES Employee (EID)
);



CREATE TABLE IF NOT EXISTS Book (
    ISBN VARCHAR(13) PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    genre VARCHAR(20),
    price DECIMAL(5,2) NOT NULL,
    publisher VARCHAR(100)
);























