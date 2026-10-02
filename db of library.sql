CREATE TABLE Books (
    BookID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    PublicationYear YEAR NOT NULL,
    Genre VARCHAR(100),
    ISBN VARCHAR(13) UNIQUE NOT NULL,
    AvailableCopies INT NOT NULL
);

CREATE TABLE Members (
    MemberID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    GradeClass VARCHAR(50),  -- NULL for staff
    ContactInfo VARCHAR(255),
    MemberType ENUM('Student', 'Staff') NOT NULL
);

CREATE TABLE Borrowings (
    BorrowingID INT PRIMARY KEY AUTO_INCREMENT,
    BookID INT,
    MemberID INT,
    BorrowDate DATE NOT NULL,
    DueDate DATE NOT NULL,
    ReturnDate DATE,
    OverdueFee DECIMAL(10, 2),
    FOREIGN KEY (BookID) REFERENCES Books(BookID),
    FOREIGN KEY (MemberID) REFERENCES Members(MemberID)
);

CREATE TABLE Reservations (
    ReservationID INT PRIMARY KEY AUTO_INCREMENT,
    BookID INT,
    MemberID INT,
    ReservationDate DATE NOT NULL,
    NotificationSent BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (BookID) REFERENCES Books(BookID),
    FOREIGN KEY (MemberID) REFERENCES Members(MemberID)
);

CREATE TABLE Reviews (
    ReviewID INT PRIMARY KEY AUTO_INCREMENT,
    BookID INT,
    MemberID INT,
    ReviewText TEXT,
    Rating INT CHECK (Rating BETWEEN 1 AND 5),
    FOREIGN KEY (BookID) REFERENCES Books(BookID),
    FOREIGN KEY (MemberID) REFERENCES Members(MemberID)
);


-- Sample Books
INSERT INTO Books (Title, Author, PublicationYear, Genre, ISBN, AvailableCopies) VALUES
('To Kill a Mockingbird', 'Harper Lee', 1960, 'Fiction', '9780061120084', 5),
('1984', 'George Orwell', 1949, 'Dystopian', '9780451524935', 3);

-- Sample Members
INSERT INTO Members (Name, GradeClass, ContactInfo, MemberType) VALUES
('John Doe', '10A', 'john.doe@example.com', 'Student'),
('Jane Smith', NULL, 'jane.smith@example.com', 'Staff');

-- Sample Borrowings
INSERT INTO Borrowings (BookID, MemberID, BorrowDate, DueDate, ReturnDate, OverdueFee) VALUES
(1, 1, '2024-08-01', '2024-08-15', NULL, NULL);

-- Sample Reservations
INSERT INTO Reservations (BookID, MemberID, ReservationDate, NotificationSent) VALUES
(2, 1, '2024-08-01', FALSE);

-- Sample Reviews
INSERT INTO Reviews (BookID, MemberID, ReviewText, Rating) VALUES
(1, 1, 'A timeless classic with deep themes.', 5);


--Search for Books by Title
SELECT * FROM Books WHERE Title LIKE '%1984%';

--List All Books Borrowed by a Member
SELECT B.Title, Bo.BorrowDate, Bo.DueDate, Bo.ReturnDate
FROM Borrowings Bo
JOIN Books B ON Bo.BookID = B.BookID
WHERE Bo.MemberID = 1;

--Check Overdue Books
SELECT B.Title, Bo.DueDate, DATEDIFF(CURDATE(), Bo.DueDate) AS DaysOverdue
FROM Borrowings Bo
JOIN Books B ON Bo.BookID = B.BookID
WHERE Bo.ReturnDate IS NULL AND Bo.DueDate < CURDATE();


-- Add a new reservation
INSERT INTO Reservations (BookID, MemberID, ReservationDate) VALUES (1, 2, CURDATE());

-- Notify member when book becomes available (update notification status)
UPDATE Reservations SET NotificationSent = TRUE WHERE ReservationID = 1;
