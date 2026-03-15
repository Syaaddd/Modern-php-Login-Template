<?php
/**
 * Session Management
 * Initialize and configure secure sessions
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    // Session security configuration
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
    
    session_start();
    
    // Regenerate session ID periodically to prevent session fixation
    $_SESSION['created'] = time();
}

// Session timeout (30 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();
