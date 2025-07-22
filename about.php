<?php
// ho_dashboard.php

if (session_status() === PHP_SESSION_NONE) session_start();


// First check, whether logged in user_id is not available or role_type is not 'HO' . If so, 
// then sends back to login.php. Only Logged in Head office(HO) user can access this page.
if (!isset($_SESSION['user_id']) || ($_SESSION['role_type_name'] ?? '') !== 'HO') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About | Trimatric Architects</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- HO Menu CSS -->
    <link rel="stylesheet" href="css/menu_ho.css">
    <style>
        html, body {height: 100%;    
                    overflow-x: hidden; 
                    max-width: 100vw;
            }
        body {
            background: #f6fafd;
            min-height: 100vh;
        }
        .dashboard-cards .card {
            border-radius: 1rem;
        }
        .dashboard-cards .card-body {
            padding: 1.2rem 1.4rem;
        }
        .dashboard-cards .badge {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
<?php include 'include/header.php'; ?>
<?php include 'include/menu_ho.php'; ?>


<div class="container main-content py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <img src="image/office_interior_1.jpg" class="img-fluid rounded shadow section-image" alt="Modern Office Interior">
        </div>
        <div class="col-md-6">
            <h1 class="main-title mb-3">About Trimatric Architects & Engineers</h1>
            <p class="section-lead">
                Trimatric is a leading interior & architectural firm in Bangladesh, known for innovative, functional, and sustainable design solutions since 2009.
            </p>
            <ul class="about-list fs-5">
                <li><i class="fa fa-check-circle text-primary me-2"></i> Residential, Commercial & Industrial Interiors</li>
                <li><i class="fa fa-check-circle text-primary me-2"></i> Architecture & Space Planning</li>
                <li><i class="fa fa-check-circle text-primary me-2"></i> Turnkey Project Execution</li>
                <li><i class="fa fa-check-circle text-primary me-2"></i> Client-Focused, Modern Approach</li>
            </ul>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="section-title mb-3">Our Mission</h2>
            <p>
                We transform spaces into inspiring environments that improve quality of life and business productivity. Every project is unique and we deliver tailor-made solutions with attention to detail and global best practices.
            </p>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="section-title mb-3">Why Choose Us?</h2>
            <ul class="about-list fs-5">
                <li><i class="fa fa-user-tie text-primary me-2"></i> Experienced architects & designers</li>
                <li><i class="fa fa-cubes text-primary me-2"></i> 250+ completed projects</li>
                <li><i class="fa fa-lightbulb text-primary me-2"></i> Modern technology & sustainable practices</li>
                <li><i class="fa fa-handshake text-primary me-2"></i> Full support from concept to completion</li>
            </ul>
        </div>
        <div class="col-md-6">
            <img src="image/office_interior_2.jpg" class="img-fluid rounded shadow section-image" alt="Contemporary Office Design">
        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>

<!-- JS Scripts at bottom for fast loading -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
</body>
</html>
