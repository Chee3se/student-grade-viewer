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

CREATE TABLE Subjects (
    ID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    teacher_id INT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (teacher_id) REFERENCES Teachers(ID)
);

CREATE TABLE Grades (
    ID INT NOT NULL AUTO_INCREMENT,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    grade DECIMAL(5,2) NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (student_id) REFERENCES Students(ID),
    FOREIGN KEY (subject_id) REFERENCES Subjects(ID)
);

# seeder
INSERT INTO Users (name, email, password, role, image) VALUES
('Admin', 'admin@example.com', 'password', 'admin', 'default.png'),
('Teacher', 'teacher@example.com', 'password', 'teacher', 'default.png'),
('Student', 'student@example.com', 'password', 'student', 'default.png');

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