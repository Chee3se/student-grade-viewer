CREATE DATABASE IF NOT EXISTS studio_class;
USE studio_class;

CREATE TABLE IF NOT EXISTS Users (
    ID INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher', 'admin') default 'student',
    image VARCHAR(255),
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS Students (
    ID INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (user_id) REFERENCES Users(ID)
);

CREATE TABLE IF NOT EXISTS Teachers (
    ID INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (user_id) REFERENCES Users(ID)
);

CREATE TABLE IF NOT EXISTS Subjects (
    ID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    teacher_id INT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (teacher_id) REFERENCES Teachers(ID)
);

CREATE TABLE IF NOT EXISTS Grades (
    ID INT NOT NULL AUTO_INCREMENT,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    grade DECIMAL(5,2) NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (student_id) REFERENCES Students(ID),
    FOREIGN KEY (subject_id) REFERENCES Subjects(ID)
);

# seeder
INSERT INTO Users (first_name, last_name, email, password, role, image) VALUES
-- Admin
('Marta', 'Ozoliņa', 'admin@example.com', 'password', 'admin', 'default.png'),

-- Teachers
('Anna', 'Kalniņa', 'teacher@example.com', 'password', 'teacher', 'default.png'),
('Roberts', 'Liepa', 'teacher2@example.com', 'password', 'teacher', 'default.png'),

-- Students
('Jānis', 'Bērziņš', 'student@example.com', 'password', 'student', 'default.png'),
('Agnese', 'Kronīte', 'student2@example.com', 'password', 'student', 'default.png'),
('Mārtiņš', 'Mazais', 'student3@example.com', 'password', 'student', 'default.png'),
('Paula', 'Līdaka', 'student4@example.com', 'password', 'student', 'default.png'),
('Sandis', 'Pumpurs', 'student5@example.com', 'password', 'student', 'default.png'),
('Edgars', 'Cielēns', 'student6@example.com', 'password', 'student', 'default.png'),
('Linda', 'Zirne', 'student7@example.com', 'password', 'student', 'default.png'),
('Katrīna', 'Vītola', 'student8@example.com', 'password', 'student', 'default.png'),
('Rihards', 'Bitītis', 'student9@example.com', 'password', 'student', 'default.png'),
('Evija', 'Eglīte', 'student10@example.com', 'password', 'student', 'default.png'),
('Niks', 'Zalktis', 'student11@example.com', 'password', 'student', 'default.png'),
('Anete', 'Gailīte', 'student12@example.com', 'password', 'student', 'default.png'),
('Daniels', 'Buks', 'student13@example.com', 'password', 'student', 'default.png'),
('Vita', 'Strauta', 'student14@example.com', 'password', 'student', 'default.png'),
('Maksis', 'Putniņš', 'student15@example.com', 'password', 'student', 'default.png');

INSERT INTO Students (user_id) VALUES
(3);

INSERT INTO Teachers (user_id) VALUES
(2);

INSERT INTO Subjects (name, description, teacher_id) VALUES
('Matemātika', 'Matemātika I', 1),
('Ķīmija', 'Ķīmija I', 1);

INSERT INTO Grades (student_id, subject_id, grade) VALUES
(1, 1, 5.0),
(1, 2, 4.5);