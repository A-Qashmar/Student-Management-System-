DROP database if exists SMS;
CREATE database SMS;
USE SMS;

-- Classes
CREATE TABLE Classes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    class_name VARCHAR(100) NOT NULL UNIQUE
);

-- Users (Admin + Students)
CREATE TABLE Users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) NOT NULL,
    class_id INT NULL,
    FOREIGN KEY (class_id) REFERENCES Classes(id) ON DELETE SET NULL
);

-- Marks (subjects fixed inside table)
CREATE TABLE Marks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    subject VARCHAR(50) NOT NULL,
    mark INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES Users(id) ON DELETE CASCADE,
    UNIQUE(student_id, subject)
);

-- Default admin
INSERT INTO Users (name, email, password, role)
VALUES ('Admin', 'admin@sms.com', '$2y$10$m5LnJZnvgPlOI7PpD56tn.WH8ho.wMHLRlYcH.hvlUENuHikl6O1S', 'Admin');