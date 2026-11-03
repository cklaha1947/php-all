<?php
// Database Initialization Script
// Run this file once to create the database and table

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new mysqli($servername, $username, $password);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS student_db";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully!<br>";
    } else {
        echo "Error creating database: " . $conn->error . "<br>";
    }
    
    // Select the database
    $conn->select_db("student_db");
    
    // Create students table
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        roll_number VARCHAR(20) NOT NULL UNIQUE,
        grade VARCHAR(2),
        phone VARCHAR(15),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table 'students' created successfully!<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
    
    // Insert sample data
    $sql = "INSERT INTO students (name, email, roll_number, grade, phone) VALUES 
            ('John Doe', 'john@example.com', 'STU001', 'A', '9876543210'),
            ('Jane Smith', 'jane@example.com', 'STU002', 'B', '9876543211'),
            ('Mike Johnson', 'mike@example.com', 'STU003', 'A', '9876543212')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Sample data inserted successfully!<br>";
    } else {
        if (strpos($conn->error, "Duplicate") === false) {
            echo "Note: " . $conn->error . "<br>";
        }
    }
    
    echo "<h3 style='color: green;'>Database setup complete! You can now use the CRUD application.</h3>";
    echo "<a href='index.php' style='color: blue; text-decoration: underline;'>Go to Student Management</a>";
    
    $conn->close();
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
