<?php
// Start session FIRST before anything else
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if form is submitted
if (!isset($_POST['username'])) {
    redirect('index.php');
}

// Get input data
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validate input
if (empty($username) || empty($password)) {
    setFlashMessage('error', 'Username and password are required.');
    redirect('index.php');
}

try {
    // Find user by username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Check if user exists and password matches
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        $stmt->close();
        $conn->close();
        
        // Redirect to dashboard
        redirect('dashboard.php');
    } else {
        // Invalid credentials
        $stmt->close();
        $conn->close();
        setFlashMessage('error', 'Invalid username or password.');
        redirect('index.php');
    }
} catch (Exception $e) {
    setFlashMessage('error', 'An error occurred. Please try again.');
    redirect('index.php');
}
