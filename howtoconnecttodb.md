1. Run XAMPP 
2. Start Apache and MySQL
3. Open http://localhost/phpmyadmin/
4. Press SQL and Run the Queries below
-- Create the database
CREATE DATABASE userDB;

-- Use the newly created database
USE userDB;

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    profilePhoto LONGBLOB NOT NULL
);


4. Note the default credentials assigned to the DB
username "root"
password ""

