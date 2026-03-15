<?php
/**
 * Helper Functions
 * Common utility functions for the application
 */

/**
 * Sanitize user input to prevent XSS
 * @param string $data
 * @return string
 */
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

/**
 * Redirect to a specific URL
 * @param string $url
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Set a flash message
 * @param string $type - 'success', 'error', 'warning', 'info'
 * @param string $message
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_message'] = $message;
}

/**
 * Get and clear flash message
 * @return array|null - ['type' => string, 'message' => string] or null
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $type = $_SESSION['flash_type'] ?? 'info';
        $message = $_SESSION['flash_message'];

        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);

        return ['type' => $type, 'message' => $message];
    }
    return null;
}

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

/**
 * Require user to be logged in, redirect to login if not
 */
function requireLogin() {
    if (!isLoggedIn()) {
        redirect('index.php');
    }
}

/**
 * Get current logged in user's ID
 * @return int|null
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current logged in user's username
 * @return string|null
 */
function getCurrentUsername() {
    return $_SESSION['username'] ?? null;
}
