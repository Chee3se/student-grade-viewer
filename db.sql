CREATE DATABASE IF NOT EXISTS studio_class;
USE studio_class;

CREATE TABLE IF NOT EXISTS Users (
    ID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher') default 'student',
    image VARCHAR(255),
    PRIMARY KEY (ID)
);

# the password is "password" for both users
INSERT INTO Users (name, email, password, role, image) VALUES
('Teacher', 'teacher@example.com', 'password', 'teacher', 'default.png'),
('Student', 'student@example.com', 'password', 'student', 'default.png')

