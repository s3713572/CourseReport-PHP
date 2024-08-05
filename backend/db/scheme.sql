CREATE DATABASE IF NOT EXISTS CourseReport;

-- give devuser permission
GRANT ALL PRIVILEGES ON CourseReport.* TO 'devuser'@'%';

-- refresh permission
FLUSH PRIVILEGES;

use CourseReport;

-- Create Users Table
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL
);

-- Create Courses Table
CREATE TABLE Courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL
);

-- Create Enrolments table
CREATE TABLE Enrolments (
    enrolment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    completion_status ENUM('not_started', 'in_progress', 'completed') NOT NULL DEFAULT 'not_started',
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);