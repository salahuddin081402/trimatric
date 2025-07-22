<?php
// ho_dashboard.php

if (session_status() === PHP_SESSION_NONE) session_start();


// First check, logged in user_id is not available or role_type is not 'HO' . If so, 
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
    <title>Services | Trimatric Architects</title>
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
    <div class="mb-4">
        <h1 class="main-title mb-4">Our Services</h1>
        <p class="section-lead">
            Trimatric delivers comprehensive architectural and interior solutions for modern living, working, and business needs.
        </p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card service-card h-100 border-0 shadow-sm">
                <img src="image/service_design.jpg" class="card-img-top rounded-top" alt="Interior Design">
                <div class="card-body">
                    <h5 class="card-title">Interior Design</h5>
                    <p class="card-text">Contemporary, functional, and elegant solutions for offices, residences, and commercial spaces—delivered with creativity and efficiency.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card service-card h-100 border-0 shadow-sm">
                <img src="image/service_architecture.jpg" class="card-img-top rounded-top" alt="Architecture">
                <div class="card-body">
                    <h5 class="card-title">Architecture</h5>
                    <p class="card-text">End-to-end architectural planning and design, including 3D visualization, space planning, and sustainable building practices.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card service-card h-100 border-0 shadow-sm">
                <img src="image/service_turnkey.jpg" class="card-img-top rounded-top" alt="Turnkey Projects">
                <div class="card-body">
                    <h5 class="card-title">Turnkey Projects</h5>
                    <p class="card-text">From concept to completion: full-service execution of interior and construction projects—on time, on budget, with guaranteed quality.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h2 class="section-title mb-3">Other Key Services</h2>
        <ul class="about-list fs-5">
            <li><i class="fa fa-cube text-primary me-2"></i> Space Planning & Furniture Layout</li>
            <li><i class="fa fa-tree text-success me-2"></i> Landscape Design</li>
            <li><i class="fa fa-brush text-warning me-2"></i> Customized Décor & Finishes</li>
            <li><i class="fa fa-tools text-secondary me-2"></i> Site Supervision & Project Management</li>
            <li><i class="fa fa-users text-info me-2"></i> Consultancy for Renovation & Remodeling</li>
        </ul>
    </div>
</div>

<?php include 'include/footer.php'; ?>

<!-- JS Scripts at bottom for fast loading -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
</body>
</html>
