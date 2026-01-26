CREATE DATABASE IF NOT EXISTS contact_manager;
USE contact_manager;

-- Table to store user information
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- Primary key for users
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,   -- Unique username for login
    password_hash VARCHAR(255) NOT NULL     -- Store hashed passwords not original
    token VARCHAR(255),                     -- Authentication token
);

-- Table to store contact information
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Primary key for contacts
    user_id INT NOT NULL,               -- Foreign key to link contact to a user
    first_name VARCHAR(50) NOT NULL,    -- Unique first name per user
    last_name VARCHAR(50),    
    email VARCHAR(100),                 -- Optional email, not unique
    personal_phone VARCHAR(20),                  -- Optional phone number, not unique
    work_phone VARCHAR(20),                  -- Optional phone number, not unique
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    /*
    * Foreign key constraint to link contacts to users
    * Deletes contacts if the associated user is deleted
    */
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);