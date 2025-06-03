CREATE DATABASE IF NOT EXISTS studio_class;
USE studio_class;

CREATE TABLE IF NOT EXISTS Users (
    id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher', 'admin') default 'student',
    image VARCHAR(255),
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS Subjects (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    user_id INT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (user_id) REFERENCES Users(ID)
);

CREATE TABLE IF NOT EXISTS Grades (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    subject_id INT NOT NULL,
    grade DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (ID),
    FOREIGN KEY (user_id) REFERENCES Users(ID),
    FOREIGN KEY (subject_id) REFERENCES Subjects(ID)
);

# seeder
INSERT INTO Users (first_name, last_name, email, password, role, image) VALUES
-- Admin
('Marta', 'Ozoliņa', 'admin@example.com', 'password', 'admin', '/images/default.png'),

-- Teachers
('Anna', 'Kalniņa', 'teacher@example.com', 'password', 'teacher', '/images/default.png'),
('Roberts', 'Liepa', 'teacher2@example.com', 'password', 'teacher', '/images/default.png'),

-- Students
('Jānis', 'Bērziņš', 'student@example.com', 'password', 'student', '/images/default.png'),
('Agnese', 'Kronīte', 'student2@example.com', 'password', 'student', '/images/default.png'),
('Mārtiņš', 'Mazais', 'student3@example.com', 'password', 'student', '/images/default.png'),
('Paula', 'Līdaka', 'student4@example.com', 'password', 'student', '/images/default.png'),
('Sandis', 'Pumpurs', 'student5@example.com', 'password', 'student', '/images/default.png'),
('Edgars', 'Cielēns', 'student6@example.com', 'password', 'student', '/images/default.png'),
('Linda', 'Zirne', 'student7@example.com', 'password', 'student', '/images/default.png'),
('Katrīna', 'Vītola', 'student8@example.com', 'password', 'student', '/images/default.png'),
('Rihards', 'Bitītis', 'student9@example.com', 'password', 'student', '/images/default.png'),
('Evija', 'Eglīte', 'student10@example.com', 'password', 'student', '/images/default.png'),
('Niks', 'Zalktis', 'student11@example.com', 'password', 'student', '/images/default.png'),
('Anete', 'Gailīte', 'student12@example.com', 'password', 'student', '/images/default.png'),
('Daniels', 'Buks', 'student13@example.com', 'password', 'student', '/images/default.png'),
('Vita', 'Strauta', 'student14@example.com', 'password', 'student', '/images/default.png'),
('Maksis', 'Putniņš', 'student15@example.com', 'password', 'student', '/images/default.png');

INSERT INTO Subjects (name, description, user_id) VALUES
('Matemātika', 'Matemātika I', 2),
('Ķīmija', 'Ķīmija I', 3),
('Fizika', 'Fizika I', 2),
('Bioloģija', 'Bioloģija I',2),
('Programmēšana', 'Programmēšana I', 3);

INSERT INTO Grades (user_id, subject_id, grade) VALUES
(4, 1, 8.5),
(4, 2, 9.0),
(4, 3, 7.5),
(4, 4, 8.0),
(5, 1, 6.0),
(5, 2, 7.5),
(5, 3, 8.0),
(5, 4, 9.0),
(6, 1, 7.0),
(6, 2, 8.5),
(6, 3, 9.0),
(6, 5, 7.5),
(7, 1, 8.0),
(7, 2, 9.5),
(7, 3, 8.0),
(7, 4, 9.0);