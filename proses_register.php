<?php
// Start session FIRST before anything else
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if form is submitted
if (!isset($_POST['username'])) {
    redirect('register.php');
}

// Get input data
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate input
$errors = [];

// Validate username
if (empty($username)) {
    $errors[] = 'Username is required.';
} elseif (strlen($username) < 3) {
    $errors[] = 'Username must be at least 3 characters.';
} elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    $errors[] = 'Username can only contain letters, numbers, and underscores.';
}

// Validate email
if (empty($email)) {
    $errors[] = 'Email is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
}

// Validate password
if (empty($password)) {
    $errors[] = 'Password is required.';
} elseif (strlen($password) < 6) {
    $errors[] = 'Password must be at least 6 characters.';
}

// Validate confirm password
if ($password !== $confirm_password) {
    $errors[] = 'Passwords do not match.';
}

// If there are errors, redirect back with error message
if (!empty($errors)) {
    setFlashMessage('error', implode(' ', $errors));
    redirect('register.php');
}

try {
    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        setFlashMessage('error', 'Username or email already exists.');
        redirect('register.php');
    }
    $stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        setFlashMessage('success', 'Registration successful! Please sign in.');
        redirect('index.php');
    } else {
        throw new Exception("Failed to execute insert statement: " . $stmt->error);
    }

} catch (Exception $e) {
    setFlashMessage('error', 'An error occurred. Please try again.');
    redirect('register.php');
}
