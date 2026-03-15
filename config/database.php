<?php
/**
 * Database Connection
 * MySQLi connection to MySQL database
 */

$host = 'localhost';
$dbname = 'login_db';
$username = 'root';
$password = ''; // Default XAMPP MySQL password is empty

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");
