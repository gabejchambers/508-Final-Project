#CREATE TABLES

CREATE TABLE IF NOT EXISTS Store(
    SID CHAR(4) PRIMARY KEY,
    address VARCHAR(100),
    manager CHAR(4),
    branch_name VARCHAR(15) UNIQUE,
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
    TID INT(11),
    PRIMARY KEY (email, TID),
    FOREIGN KEY (email) REFERENCES Customer (email),
    FOREIGN KEY (TID) REFERENCES Transaction (TID)
);


CREATE TABLE IF NOT EXISTS Transaction (
    TID INT(11) PRIMARY KEY AUTO_INCREMENT,
    cashier CHAR(4),
    customer varchar(20),
    is_return tinyint(1),
    FOREIGN KEY (customer) REFERENCES Customer(email),
    FOREIGN KEY (cashier) REFERENCES Employee (EID)
);


CREATE TABLE Merchandise (
    transaction int(11),
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



DROP TRIGGER IF EXISTS insTrns_mrch_custTrns;
DELIMITER //
CREATE TRIGGER insTrns_mrch_custTrns
    AFTER INSERT ON Transaction
    FOR EACH ROW
BEGIN
    INSERT INTO Merchandise (MID, transaction) VALUES (new.TID+1000, new.TID);

    IF(new.customer IS NOT NULL) THEN
        INSERT INTO Customer_Transactions VALUES (new.customer, new.TID);
    END IF;
END//
DELIMITER ;


#when deleting an employee, take care of all tables where they could be referneced
DELIMITER //
CREATE TRIGGER delete_employee_check
    BEFORE DELETE ON Employee
    FOR EACH ROW
BEGIN
    DECLARE temp_eid char(4);

    SET temp_eid = 0000;

    #if firing a manager:
    SELECT e.EID INTO temp_eid
    FROM Store s, Employee e
    where e.EID = s.manager and e.EID = old.EID;
    IF temp_eid is not NULL THEN
        update Store set manager = null WHERE manager = old.EID;
    end if;

    #if firing a supervisor or someone who is supervised:
    DELETE FROM Supervise where shift_lead = old.EID or employee = old.EID;

    #if firing an employee who has made a transaction:
    update Transaction set cashier = null WHERE cashier = old.EID;

END //
DELIMITER ;

/*
$sql = "CREATE TRIGGER insTrns_mrch_custTrns \n"

    . "AFTER INSERT ON Transaction\n"

    . "FOR EACH ROW \n"

    . "BEGIN\n"

    . "	IF (SELECT COUNT(*) FROM Customer WHERE email = new.customer) > 0 THEN\n"

    . "		INSERT INTO Customer_Transactions VALUES (new.customer, new.TID)END IFEND";

*/

#Queries:

#Search for a book by ISBN at a specific store
/*
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
 */
















