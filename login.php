<?php
session_start();
require_once 'config/db.php';

// --------- Auto Login Block Via 'Remeber Me' Cookie Only---------
// Case: Logout is done but Cookie is not destroyed in logout.php. Token in DB Table is used for auto-login purpose
// To see the effect of this IF Block, you have to change the logout.php where you have to drop the cookie destroy part.
// Bcoz, in my logout.php I destroyed the 'rememberme' cookie'. So, it should be removed to work this auto-login block.

if (!isset($_SESSION['user_id']) && isset($_COOKIE['rememberme'])) {
    $token = $_COOKIE['rememberme']; 
    $sql = "SELECT u.*, r.role_name, rt.role_type_name 
            FROM users u
            JOIN role r ON u.role_id = r.role_id
            JOIN role_type rt ON r.role_type_id = rt.role_type_id
            WHERE u.remember_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role_id']   = $user['role_id'];
        $_SESSION['role_name'] = $user['role_name'];
        $_SESSION['role_type_name'] = $user['role_type_name'];
        // Refresh cookie expiry
        setcookie('rememberme', $token, [
            'expires' => time() + 60*60*24*30,
            'path'    => '/',
            'secure'  => false, // Need to set 'true' if using https
            'httponly'=> true,
            'samesite'=> 'Lax'
        ]);
        // Redirect according to role type
        switch ($user['role_type_name']) {
            case 'HO':         header("Location: ho_dashboard.php"); break;
            case 'Cluster':    header("Location: cluster_home.php"); break;
            case 'Client':     header("Location: client_home.php"); break;
            case 'HO Admin':   header("Location: ho_dashboard.php"); break;
            default:           header("Location: index.php"); break;
        }
        exit;  // Since, it auto log-in , i do not want to execute following code and not even the html 
    }
}

// --------- 2. STANDARD LOGIN FLOW ---------
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Invalid email address.';
    } 
    else if (empty($password)) {
        $message = "Password cannot be blank !";
    }
    else 
    {
        $sql = "SELECT u.*, r.role_name, rt.role_type_name 
                FROM users u
                JOIN role r ON u.role_id = r.role_id
                JOIN role_type rt ON r.role_type_id = rt.role_type_id
                WHERE u.email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($user = $result->fetch_assoc()) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['role_id']   = $user['role_id'];
                    $_SESSION['role_name'] = $user['role_name'];
                    $_SESSION['role_type_name'] = $user['role_type_name'];
                    error_log("LOGIN SUCCESS for: " . $user['email'] . " | Role: " . $user['role_type_name']);

                    // -------(If 'Remember Me' checked) ---------
                    if ($remember) { // This will Create a Cookie to Store a random Token. Also sets in DB Table
                        $token = bin2hex(random_bytes(32));
                        setcookie('rememberme', $token, [
                            'expires' => time() + 60*60*24*30,
                            'path'    => '/',
                            'secure'  => false, // set true if using https
                            'httponly'=> true,
                            'samesite'=> 'Lax'
                        ]);
                        $upd = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                        $upd->bind_param("si", $token, $user['id']);
                        $upd->execute();
                    } else { // If 'Remember Me' Checkbox is blank then this will clear the cookie holding the token
                        setcookie('rememberme', '', time() - 3600, '/');
                        $upd = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
                        $upd->bind_param("i", $user['id']);
                        $upd->execute();
                    }

                    // Setting a Separate cookie for Email to be used later for Auto-fill Email when user comes back to login
                    if (isset($_POST['remember'])) {
                        setcookie("email", $email, time() + 30*24*60*60, "/");
                    } else {
                        setcookie("email", "", time() - 3600, "/");
                    }
                    // Redirect according to role type
                    switch ($user['role_type_name']) {
                        case 'HO':         header("Location: ho_dashboard.php"); 
                        error_log("Redirecting to ho_dashboard.php");
                        break;
                        case 'Cluster':    header("Location: cluster_home.php"); break;
                        case 'Client':     header("Location: client_home.php"); break;
                        case 'HO Admin':   header("Location: ho_dashboard.php"); break;
                        default:           header("Location: index.php"); break;
                    }
                    exit;
                } else {
                    $message = 'Invalid password.';
                }
            } else {
                $message = 'Email not found.';
            }
        } else {
            $message = 'Database error.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Trimatric</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background: #f6f8fa; }
        .login-container { max-width: 410px; margin: 80px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 2.5rem 2rem;}
        .brand-logo { width: 60px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="text-center mb-3">
            <img src="image/trimatric_logo.png" class="brand-logo" alt="Trimatric Logo"><br>
            <span class="fs-4 fw-bold">Trimatric Login</span>
        </div>
        <form method="post" autocomplete="off">
            <?php if ($message): ?>
                <div class="alert alert-danger py-2"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label>Email</label>
                <input name="email" type="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? ($_COOKIE['email'] ?? '')) ?>">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember"
                    <?= isset($_POST['remember']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <button class="btn btn-primary w-100 mb-2" type="submit">Login</button>
            <div class="small text-center text-muted">
                New user? <a href="signup.php">Signup</a>
            </div>
        </form>
        <div class="mt-3 small text-muted text-center">
            If you are new, please sign up and then login.<br>
        </div>
    </div>
</body>
</html>
