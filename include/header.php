<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'No User';
$role_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] : '';
$role_name = isset($_SESSION['role_name']) ? $_SESSION['role_name'] : 'No Role';
$role_type_name = isset($_SESSION['role_type_name']) ? $_SESSION['role_type_name'] : 'No Role Type';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-0">
    <div class="container-fluid">
        <div class="row d-flex justify-content-around w-100">
            <div class="col-md-3">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="/trimatric/image/trimatric_logo.png" alt="Logo" style="height:40px; margin-right:10px;">
                    <span>Trimatric Architects & Engineers</span>
                </a>
            </div>
            <div class="col-md-5">
                <!-- Centered Nav Links -->
                <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
                <ul class="navbar-nav navbar-nav-center mb-2 mb-lg-0 gap-lg-3">
                    <li class="nav-item">
                    <a class="nav-link" href="/trimatric/ho_dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/trimatric/about.php">About</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/trimatric/services.php">Services</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/trimatric/contact.php">Contact</a>
                    </li>
                </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ms-auto d-flex align-items-center">
                    <span class="navbar-text text-light">
                        Welcome, <strong><?= htmlspecialchars($user_name) ?></strong>
                        <?= $role_name ? "(" . htmlspecialchars($role_name) . ")" : "" ?>
                    </span>
                    <a href="/trimatric/logout.php" class="btn btn-outline-light btn-sm ms-3">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>
