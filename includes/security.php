<?php
/**
 * Security Helper Functions
 * Provides CSRF protection, input sanitization, and session security
 */

// Start secure session if not already started
function init_secure_session() {
    if (session_status() === PHP_SESSION_NONE) {
        // Configure secure session settings
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_samesite', 'Strict');
        
        // Use secure cookies if HTTPS is enabled
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            ini_set('session.cookie_secure', 1);
        }
        
        session_start();
        
        // Regenerate session ID periodically to prevent session fixation
        if (!isset($_SESSION['created'])) {
            $_SESSION['created'] = time();
        } else if (time() - $_SESSION['created'] > 1800) {
            // Session created more than 30 minutes ago
            session_regenerate_id(true);
            $_SESSION['created'] = time();
        }
    }
}

// Generate CSRF token
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        // PHP 5.6+ compatible random token generation
        if (function_exists('openssl_random_pseudo_bytes')) {
            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
        } else {
            // Fallback for older PHP versions
            $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
        }
    }
    return $_SESSION['csrf_token'];
}

// Validate CSRF token
function validate_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || !isset($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

// Get CSRF token input field HTML
function csrf_token_field() {
    $token = generate_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

// Sanitize input string
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Validate email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Validate phone number (basic validation)
function validate_phone($phone) {
    return preg_match('/^[0-9]{10}$/', $phone);
}

// Hash password
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Redirect with message
function redirect_with_message($url, $message_type, $message) {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $message_type; // success, error, warning, info
    header("Location: $url");
    exit();
}

// Display flash message
function display_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = isset($_SESSION['flash_type']) ? $_SESSION['flash_type'] : 'info';
        
        $alert_classes = array(
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info'
        );
        $alert_class = isset($alert_classes[$type]) ? $alert_classes[$type] : 'alert-info';
        
        echo '<div class="alert ' . $alert_class . ' alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button></div>';
        
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_users_id']) && !empty($_SESSION['user_users_id']);
}

// Check if admin is logged in
function is_admin_logged_in() {
    return isset($_SESSION['user_admin_id']) && !empty($_SESSION['user_admin_id']);
}

// Require login (redirect if not logged in)
function require_login($redirect_url = 'login_users.php') {
    if (!is_logged_in()) {
        redirect_with_message($redirect_url, 'warning', 'Please login to continue.');
    }
}

// Require admin login
function require_admin_login($redirect_url = 'index.php') {
    if (!is_admin_logged_in()) {
        redirect_with_message($redirect_url, 'warning', 'Admin access required.');
    }
}

// Prevent SQL injection by escaping (for mysqli - use prepared statements instead when possible)
function escape_string($conn, $string) {
    return mysqli_real_escape_string($conn, $string);
}

// Rate limiting (simple implementation)
function check_rate_limit($identifier, $max_attempts = 5, $time_window = 300) {
    if (!isset($_SESSION['rate_limit'])) {
        $_SESSION['rate_limit'] = [];
    }
    
    $current_time = time();
    $key = md5($identifier);
    
    // Clean old entries
    if (isset($_SESSION['rate_limit'][$key])) {
        $_SESSION['rate_limit'][$key] = array_filter(
            $_SESSION['rate_limit'][$key],
            function($timestamp) use ($current_time, $time_window) {
                return ($current_time - $timestamp) < $time_window;
            }
        );
    } else {
        $_SESSION['rate_limit'][$key] = [];
    }
    
    // Check if limit exceeded
    if (count($_SESSION['rate_limit'][$key]) >= $max_attempts) {
        return false;
    }
    
    // Add current attempt
    $_SESSION['rate_limit'][$key][] = $current_time;
    return true;
}

// Log security events
function log_security_event($event_type, $details) {
    $log_file = __DIR__ . '/../logs/security.log';
    $log_dir = dirname($log_file);
    
    if (!file_exists($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown';
    
    $log_entry = sprintf(
        "[%s] %s | IP: %s | User-Agent: %s | Details: %s\n",
        $timestamp,
        $event_type,
        $ip,
        $user_agent,
        $details
    );
    
    error_log($log_entry, 3, $log_file);
}
?>
