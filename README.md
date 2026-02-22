Student Management System (SMS) Documentation
1. Project Overview
A simple role based Student Management System built using PHP and MySQL. The administrator manages students, classes and marks, while students can log in to view their academic report and update their profile.
________________________________________
2. Server Requirements
•	PHP 8.0 or higher
•	MySQL / MariaDB
•	Apache (XAMPP / WAMP / Laragon recommended)
•	Web Browser (Chrome / Edge / Firefox)
________________________________________
3. How to Run the Project (Step by Step)
Step 1 — Copy Project
1.	Download or extract the project folder.
2.	Place it inside your server directory:
o	XAMPP → htdocs/
o	WAMP → www/
Example:
htdocs/sms
________________________________________
Step 2 — Create Database
1.	Open phpMyAdmin
2.	Click New Database
3.	Name it:
SMS
________________________________________
Step 3 — Import Database
1.	Open the SMS database
2.	Click Import
3.	Choose the provided SQL file
4.	Click Go
The following tables will be created:
•	Classes
•	Users
•	Marks
________________________________________
Step 4 — Configure Database Connection
Open file:
db.php
Edit credentials if needed:
$host = "localhost";
$user = "root";
$password = "";
$database = "SMS";
________________________________________
Step 5 — Run Project in Browser
Open browser and go to:
http://localhost/sms/login.php
________________________________________
4. Default Admin Account
Email:
admin@sms.com
Password:
123
(Note: password stored hashed in database)
________________________________________
5. System Features
Admin
•	Add / Delete Classes
•	Add / Delete Students
•	Assign or Update Marks
•	View system statistics
Student
•	Register account
•	Login
•	View marks and grades
•	Edit profile
•	Change password
________________________________________
6. Project Workflow Explanation
Development Approach
The system was developed using a simple procedural PHP structure focusing on clarity and learning fundamentals:
•	Authentication using sessions
•	Secure password storage using hashing
•	Database interaction using prepared statements
•	Basic Bootstrap UI for usability
________________________________________
Folder Structure
sms/
│
├── admin/
│   ├── dashboard.php
│   ├── classes.php
│   ├── students.php
│   └── marks.php
│
├── student/
│   ├── dashboard.php
│   ├── profile.php
│   └── change_password.php
│
├── db.php
├── session.php
├── index.php
├── login.php
├── register.php
└── logout.php
________________________________________
Logic Flow
1.	User opens login page
2.	Credentials checked against database
3.	Password verified using password_verify
4.	Session created with role (Admin / Student)
5.	Redirect to corresponding dashboard
Admin Flow:
•	Manage students and classes
•	Insert or update marks (one mark per subject per student)
Student Flow:
•	View personal marks
•	Calculate grade automatically
•	Update profile and password
________________________________________
7. Security Measures
•	Password hashing using password_hash
•	Verification using password_verify
•	Prepared statements to prevent SQL Injection
•	Session authorization to protect pages
•	Unified login error message
________________________________________
8. Access Summary
Project URL:
http://localhost/sms/login.php
Admin Dashboard:
/admin/dashboard.php
Student Dashboard:
/student/dashboard.php
________________________________________
End of Document

