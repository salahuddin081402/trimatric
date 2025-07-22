<?php
// logout.php
// Log out the user, destroy session, clear cookies, and redirect to login

session_start();

// Optional: Remove remember_token from database if using 'remember me' cookie
if (isset($_SESSION['user_id'])) {
    require_once 'config/db.php';
    $upd = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
    $upd->bind_param("i", $_SESSION['user_id']);
    $upd->execute();
}

// Unset all session variables
$_SESSION = array();

// Destroy the session
// This code deletes the PHP session cookie (often called PHPSESSID).
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Remove the remember me cookie if set
// deletes the custom "remember me" cookie (not the session cookie)
if (isset($_COOKIE['rememberme'])) {
    setcookie('rememberme', '', time() - 3600, "/");
}

// Redirect to login page
header("Location: login.php");
exit;
?>
