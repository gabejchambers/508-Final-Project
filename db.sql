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
    FOREIGN KEY (TID) REFERENCES Merchandise (transaction)
);


CREATE TABLE Merchandise (
    transaction char(4),
    MID char(4),
    book varchar(13) NOT NULL,
    PRIMARY KEY(transaction, MID),
    FOREIGN KEY (book) REFERENCES Book(ISBN),
    FOREIGN KEY (transaction) REFERENCES Transaction(TID)
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


CREATE TABLE IF NOT EXISTS Author (
    book VARCHAR(13),
    name VARCHAR(100),
    PRIMARY KEY (book, name),
    FOREIGN KEY (book) REFERENCES Book (ISBN)
);


CREATE TABLE IF NOT EXISTS Inventory (
    store CHAR(4),
    book VARCHAR(13),
    quantity tinyint NOT NULL DEFAULT 0,
    PRIMARY KEY(store, book),
    FOREIGN KEY (book) REFERENCES Book(ISBN),
    FOREIGN KEY (store) REFERENCES Store(SID)
);




#Functions:

/* Skeleton:
DELIMITER //
CREATE FUNCTION fname(param datatype) RETURNS datatype
BEGIN
    DECLARE var datatype;

    SELECT attribute INTO var
    FROM
    WHERE ;

    RETURN var;
END//
DELIMITER ;
*/

#Search for a book by ISBN at a specific store
DELIMITER //
CREATE FUNCTION getQuantityFromISBNLocation(p_ISBN VARCHAR(13), p_SID CHAR(4)) RETURNS tinyint
BEGIN
    DECLARE r_quantity tinyint;

    SELECT i.quantity INTO r_quantity
    FROM Inventory i
    WHERE p_ISBN = i.book AND p_SID = i.store;

    RETURN r_quantity;
END//
DELIMITER ;
















